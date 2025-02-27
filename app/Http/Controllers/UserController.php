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

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar pengguna.
     */
    public function index()
    {
        try {
            $users = User::with(['profile.jobTitle'])->get();
            $firstUser = null; // Set firstUser ke null agar tidak ada user yang terpilih otomatis
            $inactivatedAccounts = InactivatedAccount::where('expires_at', '>', now())->get();

            return view('users', compact(
                'users', 
                'firstUser', 
                'inactivatedAccounts'
            ));
        } catch (\Exception $e) {
            \Log::error('Error in index: ' . $e->getMessage());
            return view('users')->with('error', 'Failed to load users');
        }
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

                // Try to send email
                Log::info('Attempting to send email...');
                Mail::to($request->email)->send(new UserInvitationMail($request->email, $token));
                Log::info('Email sent successfully');

                // If we got here, everything worked
                DB::commit();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Invitation sent successfully'
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Error during invitation process: ' . $e->getMessage());
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Invitation failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Failed to send invitation. Please try again.'
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

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            
            $validator = Validator::make($request->all(), [
                'name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'role_id' => 'nullable|exists:roles,id',
                'job_title' => 'nullable|exists:job_titles,id',
                'department' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $user->update($request->all());
            
            $updatedUser = User::select('users.*', 'roles.name as role_name', 'job_titles.name as job_title_name')
                ->leftJoin('roles', 'users.role_id', '=', 'roles.id')
                ->leftJoin('job_titles', 'users.job_title', '=', 'job_titles.id')
                ->where('users.id', $id)
                ->first();

            return response()->json([
                'success' => 'User updated successfully',
                'user' => $updatedUser
            ]);
        } catch (\Exception $e) {
            \Log::error('Update error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update user'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['success' => 'User deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }

    // Update getRoleId helper function if you have it
    private function getRoleId($roleName)
    {
        return strtolower($roleName) === 'administrator' ? 1 : 2;
    }
}
