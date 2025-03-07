<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use App\Models\Department;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    public function index()
    {
        $jobTitles = JobTitle::all();
        return view('settings.system.partials.add', compact('jobTitles'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('settings.system.partials.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:job_titles',
            'description' => 'nullable|string',
            'department_id' => 'nullable|exists:departments,id'
        ]);

        try {
            $validated['department_id'] = $validated['department_id'] ?? null;
            JobTitle::create($validated);

            return redirect()->route('system.general-workspace')
                ->with('success', 'Job title added successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add job title: ' . $e->getMessage())
                ->withInput();
        }
    }
    

    public function edit($id)
    {
        $jobTitle = JobTitle::findOrFail($id);
        return view('settings.system.partials.edit', compact('jobTitle'));
    }

    public function update(Request $request, JobTitle $jobTitle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $jobTitle->update($validated);

        return redirect()->route('system.general-workspace')
            ->with('success', 'Job title updated successfully!');
    }

    public function destroy(JobTitle $jobTitle)
    {
        $jobTitle->delete();
        return redirect()->back()->with('success', 'Job title deleted successfully!');
    }
}
