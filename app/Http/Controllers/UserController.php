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
        
        // Debug logging
        foreach($users as $user) {
            \Log::info('User profile:', [
                'user_id' => $user->id,
                'has_profile' => $user->profile ? 'yes' : 'no',
                'job_title' => $user->profile?->jobTitle?->name ?? 'none'
            ]);
        }
        
        return view('users', compact('users'));
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
            return view('users.tabs.leave-planner', compact('user'));
        } catch (\Exception $e) {
            return '<div class="error">Failed to load leave planner data</div>';
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

    public function edit($id)
    {
        try {
            // Load user with all necessary relationships
            $selectedUser = User::with(['profile.department', 'profile.jobTitle', 'workingHours'])->findOrFail($id);
            $users = User::with(['profile.jobTitle', 'role'])->get();
            $departments = Department::all();
            $jobTitles = JobTitle::all();
    
            // Load working hours
            $workingHours = $selectedUser->workingHours->keyBy('day');
    
            // Log for debugging
            Log::info('Edit user data:', [
                'user_id' => $selectedUser->id,
                'profile' => $selectedUser->profile,
                'department' => $selectedUser->profile?->department,
                'job_title' => $selectedUser->profile?->jobTitle,
                'working_hours' => $workingHours
            ]);
    
            return view('users', [
                'users' => $users,
                'selectedUser' => $selectedUser,
                'showEditForm' => true,
                'showUserDetail' => true,
                'departments' => $departments,
                'jobTitles' => $jobTitles,
                'workingHours' => $workingHours,
                'detailUser' => [
                    'id' => $selectedUser->id,
                    'name' => $selectedUser->profile?->name ?? $selectedUser->email,
                    'email' => $selectedUser->email,
                    'avatar' => $selectedUser->profile?->avatar ? 
                        Storage::url($selectedUser->profile->avatar) : 
                        asset('images/change-photo.svg')
                ],
                'currentUser' => $selectedUser
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error loading user edit form: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Failed to load user data. Please try again.');
        }
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
            ]);

            // Update profile
            $profile = $user->profile ?? $user->profile()->create([]);
            $profile->update([
                'name' => $validated['name'],
                'department_id' => $validated['department_id'],
                'job_title_id' => $validated['job_title_id'],
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
}