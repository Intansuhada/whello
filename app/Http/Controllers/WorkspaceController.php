<?php
// Controller: app/Http/Controllers/WorkspaceController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkspaceSetting;
use Illuminate\Support\Facades\Storage;
use App\Models\JobTitle;
use App\Models\Department;


class WorkspaceController extends Controller
{
    public function index()
    {
        // Get the first workspace record or create a new instance if none exists
        $workspace = WorkspaceSetting::first() ?? new WorkspaceSetting();
        $jobTitles = JobTitle::all();
        $departments = Department::all();
        // Pass to view
        return view('settings.system.general-workspace', compact('workspace', 'jobTitles', 'departments'));
    }

    public function update(Request $request)
    {
        // Validate the request data
        $request->validate([
            'workspace_name' => 'required|string|max:255',
            'photo_profile'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description'    => 'nullable|string',
            'url_slug'       => 'nullable|string|max:255',
            'owner_email'    => 'nullable|email',
            'team_members'   => 'nullable|integer',
            'timezone'       => 'nullable|string',
            'time_format'    => 'nullable|string',
            'date_format'    => 'nullable|string',
            'language'       => 'nullable|string',
            'currency'       => 'nullable|string',
            'hourly_rate'    => 'nullable|numeric',
        ]);

        // Get the first workspace or create a new one
        $workspace = WorkspaceSetting::first();
        if (!$workspace) {
            $workspace = new WorkspaceSetting();
        }

        // Handle photo upload if provided
        if ($request->hasFile('photo_profile')) {
            // Delete old photo if exists
            if ($workspace->photo_profile) {
                Storage::disk('public')->delete($workspace->photo_profile);
            }
            
            // Store the new photo
            $path = $request->file('photo_profile')->store('workspace_photos', 'public');
            $workspace->photo_profile = $path;
        }

        // Update all fields
        $workspace->workspace_name = $request->workspace_name;
        $workspace->description = $request->description;
        $workspace->url_slug = $request->url_slug;
        $workspace->owner_email = $request->owner_email;
        $workspace->team_members = $request->team_members;
        $workspace->timezone = $request->timezone;
        $workspace->time_format = $request->time_format;
        $workspace->date_format = $request->date_format;
        $workspace->language = $request->language;
        $workspace->currency = $request->currency;
        $workspace->hourly_rate = $request->hourly_rate;
        
        // Save the workspace
        $workspace->save();

        return redirect()->route('workspace.index')->with('success', 'Workspace settings updated successfully!');
    }

    public function deletePhoto()
    {
        $workspace = WorkspaceSetting::first();
        
        if ($workspace && $workspace->photo_profile) {
            // Delete the file from storage
            Storage::disk('public')->delete($workspace->photo_profile);
            
            // Remove the reference from the database
            $workspace->photo_profile = null;
            $workspace->save();
            
            return redirect()->route('workspace.index')->with('success', 'Photo deleted successfully!');
        }
        
        return redirect()->route('workspace.index')->with('error', 'No photo to delete.');
    }
}