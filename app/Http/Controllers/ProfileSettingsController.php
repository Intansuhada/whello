<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\JobTitle;
use App\Models\Department;  // Add this import
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProfileSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jobTitles = JobTitle::with('department')->get();
        $departments = Department::with('jobTitles')->get();
        
        return view('settings.profile', compact('user', 'jobTitles', 'departments'));
    }

    public function changePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:2048'
        ]);

        try {
            $user = auth()->user();
            $file = $request->file('photo');
            
            // Generate filename
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Save file
            $file->storeAs('public/avatars', $filename);

            // Update profile
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                ['avatar' => $filename]
            );

            return response()->json([
                'success' => true,
                'path' => asset('storage/avatars/' . $filename),
                'message' => 'Photo updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update photo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deletePhoto()
    {
        try {
            $user = auth()->user();
            
            if ($user->profile && $user->profile->avatar) {
                Storage::disk('public')->delete('avatars/' . $user->profile->avatar);
                $user->profile->update(['avatar' => null]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Profile photo deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete profile photo'
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = auth()->user();
            
            $validated = $request->validate([
                'nickname' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'about' => 'nullable|string',
                'job_title' => 'required|exists:job_titles,id',
            ]);

            // Update profile
            $user->profile()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nickname' => $validated['nickname'],
                    'name' => $validated['name'],
                    'about' => $validated['about'],
                    'job_title_id' => $validated['job_title'],
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbaharui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbaharui profile'
            ], 500);
        }
    }

    public function changeUsername(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|max:255|unique:users,username,' . Auth::id()
            ]);

            $user = Auth::user();
            $user->update([
                'username' => $request->username
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Username updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update username'
            ], 500);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'password_confirmation' => 'required'
            ]);

            $user = Auth::user();
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to change password'
            ], 500);
        }
    }

    public function verifyNewEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . Auth::id()
            ]);

            $user = Auth::user();
            $user->update([
                'email' => $request->email
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Email verification sent successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify new email'
            ], 500);
        }
    }

    public function updateWorkingHours(Request $request)
    {
        try {
            $user = Auth::user();
            $days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            
            foreach ($days as $day) {
                if ($request->has($day)) {
                    WorkingHour::updateOrCreate(
                        [
                            'user_id' => $user->id,
                            'day' => $day
                        ],
                        [
                            'morning_start' => $request->input($day . '_morning_start'),
                            'morning_end' => $request->input($day . '_morning_end'),
                            'afternoon_start' => $request->input($day . '_afternoon_start'),
                            'afternoon_end' => $request->input($day . '_afternoon_end'),
                            'is_active' => true
                        ]
                    );
                } else {
                    WorkingHour::where('user_id', $user->id)
                        ->where('day', $day)
                        ->update(['is_active' => false]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Working hours updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update working hours'
            ], 500);
        }
    }
}