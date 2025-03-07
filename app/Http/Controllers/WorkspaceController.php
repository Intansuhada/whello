<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkspaceSetting;

class WorkspaceController extends Controller
{
    public function updateWorkspace(Request $request)
    {
        $request->validate([
            'workspace_name' => 'required|string|max:255',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'url_slug' => 'required|string|max:255|unique:workspace_settings,url_slug,' . auth()->id(),
            'owner_email' => 'required|email',
            'team_members' => 'nullable|integer|min:1',
            'timezone' => 'nullable|string',
            'time_format' => 'nullable|in:12,24',
            'date_format' => 'nullable|date',
            'default_language' => 'nullable|string',
            'default_currency' => 'nullable|string',
            'default_hourly_rate' => 'nullable|numeric|min:0',
        ]);

        $workspace = WorkspaceSetting::where('user_id', auth()->id())->firstOrNew();
        
        $workspace->workspace_name = $request->workspace_name;
        $workspace->description = $request->description;
        $workspace->url_slug = $request->url_slug;
        $workspace->owner_email = $request->owner_email;
        $workspace->team_members = $request->team_members;
        $workspace->timezone = $request->timezone;
        $workspace->time_format = $request->time_format;
        $workspace->date_format = $request->date_format;
        $workspace->default_language = $request->default_language;
        $workspace->default_currency = $request->default_currency;
        $workspace->default_hourly_rate = $request->default_hourly_rate;
        $workspace->user_id = auth()->id();

        if ($request->hasFile('photo_profile')) {
            if ($workspace->photo_profile) {
                Storage::delete($workspace->photo_profile);
            }
            $path = $request->file('photo_profile')->store('workspace_profiles', 'public');
            $workspace->photo_profile = $path;
        }

        $workspace->save();

        return redirect()->route('settings.system')->with('success', 'Workspace updated successfully.');
    }
}
