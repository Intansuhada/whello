<?php

namespace App\Http\Controllers;

use App\Models\WorkspaceSetting;
use Illuminate\Http\Request;

class WorkspaceSettingController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'workspace_name' => 'nullable|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'url_slug' => 'nullable|string|max:255',
            'owner_email' => 'nullable|email',
            'team_members' => 'nullable|integer',
            'timezone' => 'nullable|string',
            'time_format' => 'nullable|in:12,24',
            'date_format' => 'nullable|string',
            'default_language' => 'nullable|string',
            'default_currency' => 'nullable|string',
            'default_hourly_rate' => 'nullable|numeric'
        ]);

        // Handle photo upload if present
        if ($request->hasFile('photo_profile')) {
            $path = $request->file('photo_profile')->store('workspace-photos', 'public');
            $validated['photo_profile'] = $path;
        }

        // Get first record or create new
        $settings = WorkspaceSetting::firstOrCreate(['id' => 1], []);
        $settings->update($validated);

        return redirect()->route('system.general-workspace')
            ->with('success', 'Workspace settings updated successfully');
    }
}
