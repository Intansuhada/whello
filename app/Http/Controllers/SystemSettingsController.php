<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Add this line
use App\Models\WorkspaceSetting;
use App\Models\WorkingDay;
use App\Models\LeaveType;
use App\Models\CompanyHoliday;
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
}