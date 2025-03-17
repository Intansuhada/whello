<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\UserInvitationMail;
use App\Models\InactivatedAccount;
use App\Models\Department;
use App\Models\JobTitle;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\UserInvite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar pengguna.
     */
    public function index()
    {
        $users = User::with(['profile.jobTitle', 'role'])->get();
        $leavePlans = DB::table('leave_plans')->get();
        $selectedUser = null;
        $showUserDetail = false;
        $detailUser = null;
        
        if ($users->count() > 0) {
            $selectedUser = $users->first();
            $detailUser = [
                'name' => $selectedUser->profile->name ?? $selectedUser->email,
                'avatar' => $selectedUser->profile && $selectedUser->profile->avatar ? 
                    Storage::url($selectedUser->profile->avatar) : 
                    asset('images/change-photo.svg')
            ];
        }
        
        return view('users', compact('users', 'leavePlans', 'selectedUser', 'detailUser', 'showUserDetail'));
    }

    /**
     * Mengundang pengguna baru melalui email.
     */
    public function invite(Request $request)
    {
        try {
            Log::info('Starting invitation process for email: ' . $request->email);
            
            $request->validate([
                'email' => 'required|email'
            ]);

            // Start transaction AFTER validation
            DB::beginTransaction();

            try {
                // Delete old records one at a time to avoid deadlocks
                $oldInvite = UserInvite::where('invite_email', $request->email)->first();
                if ($oldInvite) {
                    $oldInvite->delete();
                }

                $oldInactive = InactivatedAccount::where('email', $request->email)->first();
                if ($oldInactive) {
                    $oldInactive->delete();
                }

                Log::info('Old records cleaned up');

                // Create new records
                $token = Str::random(64);
                $expires = now()->addDays(7);

                // Create new inactive account first
                $inactiveAccount = new InactivatedAccount();
                $inactiveAccount->email = $request->email;
                $inactiveAccount->token = $token;
                $inactiveAccount->role = 'member';
                $inactiveAccount->expires_at = $expires;
                $inactiveAccount->save();

                Log::info('Inactive account created', ['id' => $inactiveAccount->id]);

                // Then create invite record
                $invite = new UserInvite();
                $invite->invite_email = $request->email;
                $invite->token = $token;
                $invite->expires_at = $expires;
                $invite->save();

                Log::info('Invite record created', ['id' => $invite->id]);

                // Add detailed logging for email sending
                Log::info('Attempting to send email to: ' . $request->email);
                try {
                    Mail::to($request->email)->send(new UserInvitationMail($request->email, $token));
                    Log::info('Email sent successfully to: ' . $request->email);
                } catch (\Swift_TransportException $e) {
                    Log::error('SMTP Error: ' . $e->getMessage());
                    throw new \Exception('Email service is not properly configured. Please contact administrator.');
                } catch (\Exception $e) {
                    Log::error('Email Error: ' . $e->getMessage());
                    throw $e;
                }

                // If we got here, everything worked
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Invitation sent successfully'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Invitation process error: ' . $e->getMessage());
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Invitation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to send invitation: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Menampilkan halaman aktivasi akun.
     */
    public function activateAccountView($token)
    {
        $credential = DB::table('inactivated_user_accounts')
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->first();

        if (!$credential) {
            return redirect()->route('auth.signin-page')
                ->with('error', 'Activation link is invalid or has expired.');
        }

        return view('activate-account', ['token' => $token, 'email' => $credential->email]);
    }

    /**
     * Mengaktifkan akun pengguna setelah memasukkan password.
     */
    public function activateAccount(Request $request, $token): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => ['required', Password::min(8)->letters()->numbers()->symbols(), 'confirmed'],
        ]);

        $credential = DB::table('inactivated_user_accounts')->where('token', $token)->first();
        if (!$credential) {
            return back()->with('error', 'Token tidak valid atau telah kedaluwarsa.');
        }

        try {
            $roleId = $credential->role === 'administrator' ? 1 : 2;

            $user = User::create([
                'email' => $credential->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'role_id' => $roleId
            ]);

            DB::table('inactivated_user_accounts')->where('token', $token)->delete();

            return redirect()->route('auth.signin-page')
                ->with('success', 'Akun berhasil diaktifkan. Silakan masuk.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengaktifkan akun.');
        }
    }

    

    public function getDetails(User $user)
    {
        return response()->json([
            'success' => true,
            'user' => $user->load('profile.jobTitle')
        ]);
    }

    public function getUserDetails($id)
    {
        try {
            $user = User::with(['profile.jobTitle'])->findOrFail($id);
            
            // Add current tab information
            $currentTab = request()->get('tab', 'overview');
            
            return response()->json([
                'success' => true,
                'user' => $user,
                'currentTab' => $currentTab
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'User tidak ditemukan'
            ], 404);
        }
    }


    public function overview($userId)
    {
        try {
            $user = User::with(['profile.jobTitle'])->findOrFail($userId);
            return view('users.tabs.overview', compact('user'));
        } catch (\Exception $e) {
            return '<div class="error">Failed to load overview data</div>';
        }
    }

    // Terapkan pola yang sama untuk semua method tab lainnya
    public function client($userId) 
    {
        try {
            $user = User::with('clients')->findOrFail($userId);
            return view('users.tabs.client', [
                'user' => $user,
                'clients' => $user->clients
            ]);
        } catch (\Exception $e) {
            \Log::error('Client tab error: ' . $e->getMessage());
            return '<div class="error">Failed to load client data</div>';
        }
    }

    public function project($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return view('users.tabs.project', compact('user'));
        } catch (\Exception $e) {
            return '<div class="error">Failed to load project data</div>';
        }
    }

    public function task($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return view('users.tabs.task', compact('user'));
        } catch (\Exception $e) {
            return '<div class="error">Failed to load task data</div>';
        }
    }

    public function leavePlanner($userId)
    {
        try {
            $user = User::findOrFail($userId);
            $leaves = DB::table('leave_plans')
                        ->where('user_id', $userId)
                        ->select('id', 'leave_type_id', 'start_date', 'end_date', 'description', 'status', 'created_at', 'updated_at')
                        ->orderBy('created_at', 'desc')
                        ->get();
    
            return view('users.tabs.leave-planner', compact('user', 'leaves'));
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => 'Failed to load leave planner data'], 500);
        }
    }
    
    public function updateLeaveStatus(Request $request, $id)
    {
        try {
            DB::table('leave_plans')
                ->where('id', $id)
                ->update(['status' => $request->status]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating leave status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status'
            ], 500);
        }
    }

    public function timeSheets($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return view('users.tabs.time-sheets', compact('user'));
        } catch (\Exception $e) {
            return '<div class="error">Failed to load time sheets data</div>';
        }
    }

    public function activities($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return view('users.tabs.activities', compact('user'));
        } catch (\Exception $e) {
            return '<div class="error">Failed to load activities data</div>';
        }
    }

    public function access($userId)
    {
        try {
            $user = User::findOrFail($userId);
            return view('users.tabs.access', compact('user'));
        } catch (\Exception $e) {
            return '<div class="error">Failed to load access data</div>';
        }
    }

    public function edit(User $user)
    {
        $selectedUser = $user;
        $showEditForm = true;
        $showUserDetail = true; // Tambahkan ini
        $departments = Department::all();
        $jobTitles = JobTitle::all();
        $users = User::with(['profile.jobTitle', 'role'])->get();
        $roles = \App\Models\Role::all();
        $detailUser = [
            'name' => $user->profile->name ?? $user->email,
            'email' => $user->email,
            'avatar' => $user->profile && $user->profile->avatar ? 
                Storage::url($user->profile->avatar) : 
                asset('images/change-photo.svg')
        ];

        return view('users', compact(
            'selectedUser',
            'showEditForm',
            'showUserDetail', // Tambahkan ini
            'departments',
            'jobTitles',
            'users',
            'roles',
            'detailUser' // Tambahkan ini
        ))->with('user_id', $user->id);  // Tambahkan ini
    }
    
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            
            $user = User::findOrFail($id);
            
            // Validate basic info
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'department_id' => 'required|exists:departments,id',
                'job_title_id' => 'required|exists:job_titles,id',
                'pay_per_hour' => 'nullable|numeric|min:0', // Add validation for pay_per_hour
            ]);

            // Update profile
            $profile = $user->profile ?? $user->profile()->create([]);
            $profile->update([
                'name' => $validated['name'],
                'department_id' => $validated['department_id'],
                'job_title_id' => $validated['job_title_id'],
                'pay_per_hour' => $validated['pay_per_hour'], // Add this line to update pay_per_hour
            ]);

            // Delete existing working hours
            $user->workingHours()->delete();

            // Insert working hours for Monday to Friday only
            $workDays = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
            foreach ($workDays as $day) {
                $user->workingHours()->create([
                    'day' => $day,
                    'morning_start' => $request->input("morning_start.$day", '08:00'),
                    'morning_end' => $request->input("morning_end.$day", '12:00'),
                    'afternoon_start' => $request->input("afternoon_start.$day", '13:00'),
                    'afternoon_end' => $request->input("afternoon_end.$day", '17:00'),
                    'is_active' => 1,
                    'type' => 'regular'
                ]);
            }

            DB::commit();

            // Return redirect with success message instead of JSON
            return redirect()
                ->route('users.index')
                ->with('success', 'Profile has been updated successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Update error: ' . $e->getMessage());
            
            // Return redirect with error message
            return redirect()
                ->back()
                ->with('error', 'Failed to update profile. Please try again.')
                ->withInput();
        }
    }
    

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User removed successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to remove user');
        }
    }
    
    // Update getRoleId helper function if you have it
    private function getRoleId($roleName)
    {
        return strtolower($roleName) === 'administrator' ? 1 : 2;
    }

    public function getLeavePlans(User $user)
    {
        try {
            $leavePlans = DB::table('leave_plans as lp')
                ->join('leave_types as lt', 'lp.leave_type_id', '=', 'lt.id')
                ->select(
                    'lp.id',
                    'lt.name as leave_type',
                    'lp.start_date',
                    'lp.end_date',
                    'lp.description',
                    'lp.status'
                )
                ->where('lp.user_id', $user->id)
                ->orderBy('lp.start_date', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'leavePlans' => $leavePlans
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching leave plans: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load leave plans'
            ], 500);
        }
    }

    public function show(User $user)
    {
        $users = User::with(['profile.jobTitle', 'role'])->get();
        $leavePlans = DB::table('leave_plans')->get();
        $detailUser = [
            'name' => $user->profile->name ?? $user->email,
            'email' => $user->email,
            'avatar' => $user->profile && $user->profile->avatar ? 
                Storage::url($user->profile->avatar) : 
                asset('images/change-photo.svg')
        ];
        
        return view('users', compact('users', 'leavePlans', 'detailUser'));
    }

    public function leaveHistory()
    {
        try {
            $user = auth()->user();
            
            // Get counts with logging
            $rejectedLeaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->where('status', 'rejected')
                ->count();  // Changed from ->get() to ->count()
                
            \Log::info('Rejected leaves count:', ['count' => $rejectedLeaves]);
            
            // Get other counts
            $approvedLeaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->count();
                
            $pendingLeaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->count();

            // Get leave plans with type information
            $leavePlans = DB::table('leave_plans as lp')
                ->join('leave_types as lt', 'lp.leave_type_id', '=', 'lt.id')
                ->select(
                    'lp.*', 
                    'lt.name as leave_type_name',
                    'lt.code'
                )
                ->where('lp.user_id', $user->id)
                ->orderBy('lp.created_at', 'desc')
                ->get();

            return view('settings.leave.history', compact(
                'leavePlans',
                'rejectedLeaves',  // Changed from rejectedCount to rejectedLeaves
                'approvedLeaves',
                'pendingLeaves'
            ));

        } catch (\Exception $e) {
            \Log::error('Error in leave history: ' . $e->getMessage());
            return back()->with('error', 'Failed to load leave history.');
        }
    }

    public function calendar()
    {
        try {
            $user = auth()->user();
            
            // Tambahkan logging untuk memeriksa nilai status yang sebenarnya
            $allLeaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->select('status')
                ->get();
                
            \Log::info('Status cuti yang ada:', $allLeaves->toArray());
            
            // Hitung ulang dengan memperhatikan case sensitivity
            $rejectedLeaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->where('status', 'rejected')
                ->count();
                
            $approvedLeaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->where('status', 'approved')
                ->count();
                
            $pendingLeaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->where('status', 'pending')
                ->count();

            // Siapkan data bulan
            $months = [];
            $year = request('year', now()->year);
            for ($m = 1; $m <= 12; $m++) {
                $months[$m] = [
                    'name' => date('F', mktime(0, 0, 0, $m, 1)),
                ];
            }

            // Debug untuk melihat data yang diambil
            \Log::info('User ID: ' . $user->id);

            // Ambil semua data cuti user dan gabungkan dengan tipe cuti
            $leaves = DB::table('leave_plans')
                ->where('user_id', $user->id)
                ->whereYear('start_date', $year) // Tambahkan filter tahun
                ->get();

            \Log::info('Leave data:', $leaves->toArray());

            // Susun data cuti per tanggal
            $leaveDays = [];
            foreach ($leaves as $leave) {
                $start = \Carbon\Carbon::parse($leave->start_date);
                $end = \Carbon\Carbon::parse($leave->end_date);
                
                // Loop setiap hari dalam rentang cuti
                for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                    $dateStr = $date->format('Y-m-d');
                    $leaveDays[$dateStr] = [
                        'status' => $leave->status,
                        'description' => $leave->description
                    ];
                    
                    // Debug untuk melihat data yang dimasukkan ke array
                    \Log::info("Adding leave day: {$dateStr}", [
                        'status' => $leave->status,
                        'description' => $leave->description
                    ]);
                }
            }

            // Data hari libur (kosong untuk sementara)
            $holidays = [];

            return view('settings.leave.calendar', compact(
                'months',
                'year',
                'holidays',
                'leaveDays', // Array berisi data cuti per tanggal
                'rejectedLeaves',
                'approvedLeaves',
                'pendingLeaves'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in calendar: ' . $e->getMessage());
            return back()->with('error', 'Gagal memuat kalender.');
        }
    }

    public function leaveStore(Request $request)
    {
        try {
            DB::table('leave_plans')->insert([
                'user_id' => auth()->id(),
                'leave_type_id' => $request->leave_type_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return redirect()->route('settings.leave.calendar')
                ->with('success', 'Leave request has been successfully submitted!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to submit leave request. Please try again.');
        }
    }
}