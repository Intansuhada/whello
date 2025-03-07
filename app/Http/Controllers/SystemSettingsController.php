<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemSettingsController extends Controller
{
    public function generalWorkspace()
    {
        $jobTitles = \App\Models\JobTitle::all(['id', 'name', 'description']);
        $departments = \App\Models\Department::all(['id', 'name', 'description']);
        return view('settings.system.general-workspace', compact('jobTitles', 'departments'));
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
        $validated = $request->validate([
            'workspace_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'slug' => 'required|string|max:255',
            'owner' => 'required|email',
            'team_members' => 'required|integer',
            'timezone' => 'required|string',
            'time_format' => 'required|in:12,24',
            'date_format' => 'required|date',
            'language' => 'required|string',
            'currency' => 'required|string',
            'hourly_rate' => 'required|string',
        ]);

        // Handle file upload if present
        if ($request->hasFile('company_logo')) {
            // Add file upload logic
        }

        // Update settings
        // Add your update logic here

        return back()->with('success', 'Workspace settings updated successfully');
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
