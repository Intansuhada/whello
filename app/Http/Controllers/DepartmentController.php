<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller  // Fixed class name
{

   
    
    public function create()
    {
        return view('settings.system.partials.createDepart');
    }

    public function edit($id)
    {
        $department = Department::findDepartmentById($id);
        return view('settings.system.partials.editDepart', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);
    
        try {
            $department->update($validated);
    
            return redirect()->route('system.general-workspace')
                ->with('success', 'Department updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update department: ' . $e->getMessage())
                ->withInput();
        }
    }
    

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->back()->with('success', 'Department deleted successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        try {
            Department::create($validated);
            return redirect()->route('system.general-workspace')
                ->with('success', 'Department created successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create department: ' . $e->getMessage())
                ->withInput();
        }
    }
}
