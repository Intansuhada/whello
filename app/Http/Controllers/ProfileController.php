<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSecurityRequest;
use App\Http\Requests\UpdateNotificationsRequest;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    public function updateSecurity(UpdateSecurityRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        if (isset($data['current_password']) && isset($data['new_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return response()->json([
                    'success' => false,
                    'errors' => ['current_password' => ['Current password is incorrect']]
                ], 422);
            }
            $user->password = Hash::make($data['new_password']);
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Security settings updated successfully'
        ]);
    }

    public function updateNotifications(UpdateNotificationsRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        $user->notificationPreferences()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'email_task_updates' => $request->boolean('email_task_updates'),
                'email_project_updates' => $request->boolean('email_project_updates'),
                'email_mentions' => $request->boolean('email_mentions'),
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Notification preferences updated successfully'
        ]);
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
}
