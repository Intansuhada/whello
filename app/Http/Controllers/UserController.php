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
                'password' => Hash::make($request->password),
                'role_id' => $roleId
            ]);

            DB::table('inactivated_user_accounts')->where('token', $token)->delete();

            return redirect()->route('auth.signin-page')
                ->with('success', 'Account activated successfully. Please sign in.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to activate account.');
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
        $user = User::with('profile')->findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'department_id' => 'nullable|exists:departments,id',
            'job_title_id' => 'nullable|exists:job_titles,id',
            'avatar' => 'nullable|image|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Update user email if changed
            $user->update([
                'email' => $validated['email']
            ]);

            // Create or update profile
            $profile = $user->profile ?? new \App\Models\UserProfile();
            $profile->user_id = $user->id; // Pastikan user_id terisi
            $profile->name = $validated['name'];
            $profile->department_id = $validated['department_id'] ?? null;
            $profile->job_title_id = $validated['job_title_id'] ?? null;

            // Handle avatar upload jika ada
            if ($request->hasFile('avatar')) {
                // Hapus avatar lama jika ada
                if ($profile->avatar) {
                    Storage::delete('public/' . $profile->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $profile->avatar = $path;
            }

            // Simpan profile
            if (!$user->profile) {
                $user->profile()->save($profile);
            } else {
                $profile->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'user' => $user->load('profile'),
                    'avatar_url' => $profile->avatar ? Storage::url($profile->avatar) : null
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Delete avatar if exists
        if ($user->profile && $user->profile->avatar) {
            Storage::delete('public/' . $user->profile->avatar);
        }
        
        // Delete profile and user
        if ($user->profile) {
            $user->profile->delete();
        }
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User removed successfully'
        ]);
    }

    // Update getRoleId helper function if you have it
    private function getRoleId($roleName)
    {
        return strtolower($roleName) === 'administrator' ? 1 : 2;
    }
}
