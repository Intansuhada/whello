<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\JobTitle;

class ProfileSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $jobTitles = JobTitle::all();
        return view('settings.profile', compact('user', 'jobTitles'));
    }

    public function changePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $user = Auth::user();
            $fileName = time() . '.' . $request->photo->extension();
            $request->photo->move(public_path('images/avatars'), $fileName);

            $user->profile()->update([
                'avatar' => $fileName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile photo updated successfully',
                'path' => url('images/avatars/' . $fileName)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile photo'
            ], 500);
        }
    }

    public function deletePhoto()
    {
        try {
            $user = Auth::user();
            
            if ($user->profile && $user->profile->avatar) {
                $path = public_path('images/avatars/' . $user->profile->avatar);
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            $user->profile()->update([
                'avatar' => null
            ]);

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
            $user = Auth::user();
            
            $request->validate([
                'nickname' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'about' => 'nullable|string',
                'job_title' => 'nullable|exists:job_titles,id'
            ]);

            $user->profile()->update([
                'nickname' => $request->nickname,
                'name' => $request->name,
                'about' => $request->about,
                'job_title_id' => $request->job_title
            ]);

            return redirect()->back()->with('success', 'Profile updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update profile');
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
}