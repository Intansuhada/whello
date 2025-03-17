<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WorkspaceSetting;
use App\Models\WorkingDay;
use App\Models\LeaveType;
use App\Models\LeavePlan;
use App\Models\CompanyHoliday;
use Carbon\Carbon;
use App\Models\TimezoneSetting;
use Illuminate\Support\Facades\Storage;

class SystemSettingsController extends Controller
{
    public function index()
    {
        return view('settings.system.index');
    }

    public function generalWorkspace()
    {
        $jobTitles = \App\Models\JobTitle::all(['id', 'name', 'description']);
        $departments = \App\Models\Department::all(['id', 'name', 'description']);
        $workspaceSettings = \DB::table('workspace_settings')->first();
        $userCount = \DB::table('users')->count();
        
        if ($workspaceSettings && $workspaceSettings->photo_profile) {
            $workspaceSettings->photo_url = Storage::url($workspaceSettings->photo_profile);
        }
        
        return view('settings.system.general-workspace', compact('jobTitles', 'departments', 'workspaceSettings', 'userCount'));
    }

    public function workingDay()
    {   
        $workingDays = WorkingDay::weekDays()->get();
        $leaveTypes = LeaveType::all();
        $companyHolidays = CompanyHoliday::all();
        $currentTimezone = TimezoneSetting::getActiveTimezone();
        
        return view('settings.system.working-day', compact(
            'workingDays', 
            'leaveTypes', 
            'companyHolidays',
            'currentTimezone'
        ));
    }

    public function projectUtility()
    {
        return view('settings.system.project-utility');
    }

    public function timeAndExpenses()
    {
        return view('settings.system.time-expenses');
    }

    public function leavePlanning()
    {
        try {
            $user = auth()->user();
            $activeView = request('view', 'calendar'); // Default to calendar view
            
            // Get leave statistics
            $remainingLeaves = 20;
            $approvedLeaves = LeavePlan::where('user_id', $user->id)
                                     ->where('status', 'approved')
                                     ->count();
            $pendingLeaves = LeavePlan::where('user_id', $user->id)
                                     ->where('status', 'pending')
                                     ->count();

            // Get leave types and leave plans
            $leaveTypes = LeaveType::all();
            $leavePlans = LeavePlan::where('user_id', $user->id)
                                  ->with('leaveType')
                                  ->orderBy('start_date', 'desc')
                                  ->get();

            $events = $leavePlans->map(function ($leave) {
                $colors = [
                    'approved' => '#4CAF50',
                    'pending' => '#FFC107',
                    'rejected' => '#f44336'
                ];

                return [
                    'id' => $leave->id,
                    'title' => $leave->leaveType->name,
                    'start' => $leave->start_date,
                    'end' => $leave->end_date,
                    'color' => $colors[$leave->status] ?? '#4CAF50',
                    'allDay' => true
                ];
            });

            return view('settings.leave-planning', compact(
                'activeView',
                'remainingLeaves',
                'approvedLeaves',
                'pendingLeaves',
                'leaveTypes',
                'leavePlans',
                'events'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in leavePlanning:', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function updateWorkingDay(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Debug log untuk melihat data yang diterima
            \Log::info('Received working days data:', $request->all());

            // Update working days
            if ($request->has('working_days')) {
                foreach ($request->working_days as $id => $data) {
                    $workingDay = WorkingDay::findOrFail($id);
                    
                    // Pastikan nilai is_working_day dikonversi dengan benar ke integer
                    $isWorkingDay = isset($data['is_working_day']) ? (int)$data['is_working_day'] : 0;
                    
                    // Debug log untuk setiap hari
                    \Log::info("Processing day ID: {$id}", [
                        'is_working_day' => $isWorkingDay,
                        'raw_data' => $data
                    ]);

                    // Update data menggunakan query builder
                    DB::table('working_days')
                        ->where('id', $id)
                        ->update([
                            'is_working_day' => $isWorkingDay,
                            'morning_start_time' => $isWorkingDay ? ($data['morning_start_time'] ?? null) : null,
                            'morning_end_time' => $isWorkingDay ? ($data['morning_end_time'] ?? null) : null,
                            'afternoon_start_time' => $isWorkingDay ? ($data['afternoon_start_time'] ?? null) : null,
                            'afternoon_end_time' => $isWorkingDay ? ($data['afternoon_end_time'] ?? null) : null
                        ]);
                }
            }

            // Update timezone if provided
            if ($request->has('timezone')) {
                TimezoneSetting::setActiveTimezone($request->timezone);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Working days and timezone updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Failed to update working days: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    public function updateProjectUtility(Request $request)
    {
        // Add validation and update logic
        return back()->with('success', 'Project utility settings updated successfully');
    }

    public function updateTimeAndExpenses(Request $request)
    {
        // Add validation and update logic
        return back()->with('success', 'Time & expenses settings updated successfully');
    }

    public function updateGeneralWorkspace(Request $request)
    {
        try {
            $validated = $request->validate([
                'workspace_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'url_slug' => 'required|string|max:255',
                'owner_email' => 'required|email',
                'team_members' => 'required|integer',
                'timezone' => 'required|string',
                'time_format' => 'required|in:12,24',
                'date_format' => 'nullable|string',
                'default_language' => 'required|string',
                'default_currency' => 'required|string',
                'default_hourly_rate' => 'nullable|numeric',
            ]);

            // Handle logo upload if present
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoPath = $logo->store('workspace-logos', 'public');
                $validated['photo_profile'] = $logoPath;
            }

            $workspace = WorkspaceSetting::firstOrNew();
            $workspace->fill($validated);
            $workspace->save();

            return redirect()->back()->with('success', 'Workspace settings updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update workspace settings: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function deleteCompanyLogo()
    {
        try {
            // Get current workspace settings
            $workspace = Workspace::first(); // Adjust this according to your actual workspace retrieval logic
            if ($workspace && $workspace->company_logo) {
                // Delete the file from storage
                Storage::delete($workspace->company_logo);

                // Update the database record
                $workspace->update(['company_logo' => null]);

                return response()->json([
                    'success' => true,
                    'message' => 'Company logo deleted successfully',
                    'data' => [
                        'avatar_url' => asset('images/image-company-logo.svg')
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No logo found to delete'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete company logo'
            ], 500);
        }
    }

    public function addLeave(Request $request)
    {
        $validated = $request->validate([
            'dayId' => 'required|exists:working_days,id',
            'leaveType' => 'required|in:holiday,vacation,sick',
            'description' => 'required|string|max:255'
        ]);

        try {
            $workingDay = WorkingDay::find($validated['dayId']);
            $workingDay->update([
                'is_working_day' => false,
                'leave_type' => $validated['leaveType'],
                'leave_description' => $validated['description']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Leave day added successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add leave day: ' . $e->getMessage()
            ], 500);
        }
    }

    public function addHoliday(Request $request)
    {
        $validated = $request->validate([
            'holidayName' => 'required|string|max:255',
            'holidayDate' => 'required|date',
            'holidayDescription' => 'nullable|string'
        ]);

        try {
            $holiday = CompanyHoliday::create([
                'name' => $validated['holidayName'],
                'date' => $validated['holidayDate'],
                'description' => $validated['holidayDescription']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Holiday added successfully',
                'data' => $holiday
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add holiday'
            ], 500);
        }
    }

    public function updateHoliday(Request $request, $id)
    {
        $holiday = CompanyHoliday::findOrFail($id);
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $holiday->update($validated);

        return redirect()->route('system.working-day')
            ->with('success', 'Holiday updated successfully');
    }

    public function deleteHoliday($id)
    {
        $holiday = CompanyHoliday::findOrFail($id);
        $holiday->delete();

        return redirect()->route('system.working-day')
            ->with('success', 'Holiday deleted successfully');
    }

    public function destroyHoliday($id)
    {
        try {
            $holiday = CompanyHoliday::findOrFail($id);
            $holiday->delete();

            return redirect()->route('system.working-day')
                ->with('success', 'Holiday deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to delete holiday: ' . $e->getMessage());
        }
    }

    public function destroyLeaveType($id)
    {
        try {
            $leaveType = LeaveType::findOrFail($id);
            $leaveType->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave type deleted successfully'
                ]);
            }

            return redirect()->route('system.working-day')
                ->with('success', 'Leave type deleted successfully');
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Failed to delete leave type'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'Failed to delete leave type');
        }
    }

    public function createLeaveType()
    {
        return view('settings.system.partials.create-leave-type');
    }

    public function storeLeaveType(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:leave_types',
            'description' => 'nullable|string'
        ]);

        LeaveType::create($validated);

        return redirect()->route('system.working-day')
            ->with('success', 'Leave type created successfully');
    }

    public function editLeaveType($id)
    {
        $leaveType = LeaveType::findOrFail($id);
        return view('settings.system.partials.edit-leave-type', compact('leaveType'));
    }

    public function updateLeaveType(Request $request, $id)
    {
        $leaveType = LeaveType::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:leave_types,code,'.$id,
            'description' => 'nullable|string'
        ]);

        $leaveType->update($validated);

        return redirect()->route('system.working-day')
            ->with('success', 'Leave type updated successfully');
    }

    public function editHoliday($id)
    {
        $holiday = CompanyHoliday::findOrFail($id);
        return view('settings.system.partials.edit-holiday', compact('holiday'));
    }

    public function createHoliday()
    {
        return view('settings.system.partials.create-holiday');
    }

    public function storeHoliday(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        CompanyHoliday::create($validated);

        return redirect()->route('system.working-day')
            ->with('success', 'Holiday created successfully');
    }

    public function updateLeavePlanning(Request $request)
    {
        try {
            // Add your leave planning update logic here
            return redirect()->back()->with('success', 'Leave planning updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update leave planning');
        }
    }

    public function storeLeavePlan(Request $request)
    {
        try {
            $validated = $request->validate([
                'leave_type_id' => 'required|exists:leave_types,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'description' => 'nullable|string'
            ]);

            $leavePlan = new LeavePlan([
                'user_id' => auth()->id(),
                'leave_type_id' => $validated['leave_type_id'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'description' => $validated['description'],
                'status' => 'pending'
            ]);

            $leavePlan->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Leave plan created successfully',
                    'data' => $leavePlan->load('leaveType')
                ]);
            }

            return redirect()->back()->with('success', 'Leave plan created successfully');
        } catch (\Exception $e) {
            \Log::error('Error creating leave plan:', ['error' => $e->getMessage()]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create leave plan: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to create leave plan: ' . $e->getMessage());
        }
    }

    public function leaveCalendar()
    {
        try {
            $user = auth()->user();
            $year = now()->year;
            
            // Fix holiday date handling with correct Carbon namespace
            $holidays = CompanyHoliday::all()->mapWithKeys(function($holiday) {
                $dateStr = Carbon::parse($holiday->date)->format('Y-m-d');
                return [$dateStr => [
                    'name' => $holiday->name,
                    'description' => $holiday->description
                ]];
            })->toArray();

            // Create months array
            $months = [];
            for ($i = 1; $i <= 12; $i++) {
                $months[$i] = [
                    'name' => date('F', mktime(0, 0, 0, $i, 1)),
                    'number' => $i
                ];
            }

            // Get leave days with status
            $leaveDays = [];
            $events = LeavePlan::where('user_id', $user->id)
                ->with('leaveType')
                ->get();

            foreach ($events as $event) {
                $start = Carbon::parse($event->start_date);
                $end = Carbon::parse($event->end_date);
                
                while ($start->lte($end)) {
                    $dateStr = $start->format('Y-m-d');
                    $leaveDays[$dateStr] = [
                        'status' => $event->status,
                        'description' => $event->description,
                        'type' => $event->leaveType->name
                    ];
                    $start = $start->copy()->addDay(); // Perbaikan untuk menghindari modifikasi date original
                }
            }

            // Debug log untuk melihat data leave
            \Log::info('Leave Days Data:', $leaveDays);

            // Get statistics
            $remainingLeaves = 20; 
            $approvedLeaves = LeavePlan::where('user_id', $user->id)
                                     ->where('status', 'approved')
                                     ->count();
            $pendingLeaves = LeavePlan::where('user_id', $user->id)
                                     ->where('status', 'pending')
                                     ->count();
            $rejectedLeaves = LeavePlan::where('user_id', $user->id)
                                     ->where('status', 'rejected')
                                     ->count();

            $leaveTypes = LeaveType::all();

            return view('settings.leave.calendar', compact(
                'remainingLeaves',
                'approvedLeaves',
                'rejectedLeaves',
                'pendingLeaves',
                'events',
                'leaveTypes',
                'year',
                'months',
                'leaveDays',
                'holidays'
            ));
        } catch (\Exception $e) {
            \Log::error('Leave Calendar Error:', ['error' => $e->getMessage()]);
            return back()->with('error', $e->getMessage());
        }
    }

    public function leaveHistory()
    {
        try {
            $leaveTypes = LeaveType::all();
            $leavePlans = LeavePlan::where('user_id', auth()->id())
                ->with('leaveType')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('settings.leave.history', compact('leaveTypes', 'leavePlans'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function getEventColor($status)
    {
        return [
            'approved' => '#4CAF50',
            'pending' => '#FFC107',
            'rejected' => '#f44336'
        ][$status] ?? '#4CAF50';
    }

    public function leaveSettings()
    {
        try {
            $leaveTypes = LeaveType::all();
            $leaveQuotas = LeaveQuota::where('user_id', auth()->id())->get();
            
            return view('settings.leave.settings', compact('leaveTypes', 'leaveQuotas'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function bookLeave() // Changed from createLeave to bookLeave
    {
        try {
            $leaveTypes = LeaveType::all();
            return view('settings.leave.book', compact('leaveTypes')); // Changed from create to book
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}