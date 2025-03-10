<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkspaceSetting;
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
        $userCount = \DB::table('users')->count(); // Add this line
        
        // Add photo URL if exists
        if ($workspaceSettings && $workspaceSettings->photo_profile) {
            $workspaceSettings->photo_url = Storage::url($workspaceSettings->photo_profile);
        }
        
        return view('settings.system.general-workspace', compact('jobTitles', 'departments', 'workspaceSettings', 'userCount'));
    }

    public function workingDay()
    {   
        return view('settings.system.working-day');
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
        // Add validation and update logic
        return back()->with('success', 'Working day settings updated successfully');
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
}
