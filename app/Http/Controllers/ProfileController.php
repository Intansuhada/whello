<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSecurityRequest;
use App\Http\Requests\UpdateNotificationsRequest;
use App\Models\UserProfile;
use App\Models\Department;
use App\Models\JobTitle;

class ProfileController extends Controller
{
    public function updateSecurity(Request $request)
    {
        try {
            $request->validate([
                'phone_number' => 'nullable|string|max:15',
                'email' => 'nullable|email',
                'current_password' => 'required_with:new_password',
                'new_password' => 'nullable|min:8|confirmed',
            ]);

            $user = auth()->user();
            $updated = false;
            
            // Update phone number in user_profiles table
            $profile = UserProfile::firstOrCreate(
                ['user_id' => $user->id],
                []
            );
            
            if ($request->filled('phone_number')) {
                $profile->phone = $request->phone_number;
                $profile->save();
                $updated = true;
            }

            // Update email
            if ($request->filled('email') && $request->email !== $user->email) {
                $user->email = $request->email;
                $updated = true;
            }

            // Update password
            if ($request->filled('new_password')) {
                if (!Hash::check($request->current_password, $user->password)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Kata sandi saat ini tidak benar'
                    ], 422);
                }
                $user->password = Hash::make($request->new_password);
                $updated = true;
            }

            if ($updated) {
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil diperbarui'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Tidak ada perubahan yang dilakukan'
            ]);

        } catch (\Exception $e) {
            \Log::error('Security update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data'
            ], 500);
        }
    }

    public function updateNotifications(Request $request)
    {
        try {
            $user = auth()->user();
            
            // Update notification settings
            $user->notificationSettings()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'client_browser_all' => $request->boolean('client_browser_all'),
                    'client_email_all' => $request->boolean('client_email_all'),
                    'project_browser_all' => $request->boolean('project_browser_all'),
                    'project_email_all' => $request->boolean('project_email_all'),
                    // Add other notification settings as needed
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Notification settings updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update notification settings'
            ], 500);
        }
    }

    public function overview()
    {
        $user = auth()->user();
        
        if (!$user) {
            return view('profile.overview', ['user' => null]);
        }

        // Debug user data
        \Log::info('User data:', [
            'id' => $user->id,
            'email' => $user->email,
            'created_at' => $user->created_at,
            'role' => $user->role,
            'status' => $user->status
        ]);

        return view('profile.overview', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255', // Changed from full_name to name
            'department_id' => 'nullable|exists:departments,id',
            'nickname' => 'nullable|string|max:255',
            'about' => 'nullable|string',
            'job_title_id' => 'nullable|exists:job_titles,id',
        ]);

        try {
            $user = auth()->user();
            
            // Get or create profile
            $profile = UserProfile::firstOrCreate(
                ['user_id' => $user->id],
                []
            );

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                if ($profile->avatar) {
                    Storage::disk('public')->delete($profile->avatar);
                }

                // Store new avatar
                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $profile->avatar = $avatarPath;
            }

            // Update profile fields
            $profile->name = $request->name; // Changed from full_name to name
            $profile->nickname = $request->nickname;
            $profile->about = $request->about;
            $profile->department_id = $request->department_id;
            $profile->job_title_id = $request->job_title_id;
            
            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully',
                'data' => [
                    'profile' => $profile->fresh(),
                    'avatar_url' => $profile->avatar ? Storage::url($profile->avatar) : null
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    public function basic()
    {
        $user = auth()->user();
        $departments = Department::all();
        $jobTitles = JobTitle::all();
        
        return view('settings.basic-profile', compact('user', 'departments', 'jobTitles'));
    }

    public function security()
    {
        $user = auth()->user();
        return view('settings.security', compact('user'));
    }

    public function notifications()
    {
        $user = auth()->user();
        return view('settings.notifications', compact('user'));
    }

    public function account()
    {
        $user = auth()->user();
        return view('settings.account', compact('user'));
    }

    public function accountSecurity()
    {
        $user = auth()->user();
        return view('settings.account-security', compact('user'));
    }

    public function updateBasic(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nickname' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'department_id' => 'required|exists:departments,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'about' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            if ($request->hasFile('avatar')) {
                if ($user->profile?->avatar) {
                    Storage::delete($user->profile->avatar);
                }
                $avatarPath = $request->file('avatar')->store('public/avatars');
                $validated['avatar'] = str_replace('public/', '', $avatarPath);
            }

            $profile = $user->profile()->updateOrCreate(
                [],
                [
                    'name' => $validated['nickname'],
                    'full_name' => $validated['full_name'],
                    'department_id' => $validated['department_id'],
                    'job_title_id' => $validated['job_title_id'],
                    'about' => $validated['about'],
                    'avatar' => $validated['avatar'] ?? $user->profile?->avatar
                ]
            );

            return redirect()
                ->route('profile.basic')
                ->with('success', 'Profile updated successfully');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function myProfile()
    {
        $user = auth()->user()->load(['profile', 'profile.department', 'profile.jobTitle']);
        $departments = Department::all();
        $jobTitles = JobTitle::all();

        return view('profile.my-profile', compact('user', 'departments', 'jobTitles'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'nickname' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'about' => 'nullable|string|max:1000',
            ]);

            $user = auth()->user();
            $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                if ($profile->avatar) {
                    Storage::disk('public')->delete($profile->avatar);
                }
                $profile->avatar = $request->file('avatar')->store('avatars', 'public');
            }

            // Update only editable fields
            $profile->nickname = $request->nickname;
            $profile->name = $request->name;
            $profile->about = $request->about;

            // Keep existing department_id and job_title_id
            if (!$profile->exists) {
                $profile->department_id = $user->profile?->department_id;
                $profile->job_title_id = $user->profile?->job_title_id;
            }

            $profile->save();

            return response()->json([
                'success' => true,
                'message' => 'Profil berhasil diperbarui',
                'data' => [
                    'profile' => $profile->fresh(),
                    'avatar_url' => $profile->avatar ? Storage::url($profile->avatar) : null
                ]
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui profil'
            ], 500);
        }
    }

    public function deletePhoto()
    {
        try {
            $user = auth()->user();
            $profile = $user->profile;

            if ($profile && $profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
                $profile->avatar = null;
                $profile->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Foto profil berhasil dihapus',
                    'data' => [
                        'avatar_url' => asset('images/default-avatar.png')
                    ]
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Tidak ada foto profil untuk dihapus'
            ]);

        } catch (\Exception $e) {
            \Log::error('Delete photo error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto profil'
            ], 500);
        }
    }
}
