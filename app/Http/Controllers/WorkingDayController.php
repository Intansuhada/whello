<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use App\Models\CompanyHoliday;
use Illuminate\Http\Request;

class WorkingDayController extends Controller
{
    public function addLeaveType(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:leave_types',
            'description' => 'nullable|string'
        ]);

        $leaveType = LeaveType::create($request->all());

        return response()->json([
                'code' => $request->code,
                'description' => $request->descriptiony',
            ]);ta' => $leaveType
        ]);
            return response()->json([
                'success' => true,
                'message' => 'Leave type added successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([d|string|max:255',
                'success' => false,red|date',
                'message' => 'Error adding leave type: ' . $e->getMessage()
            ], 500);
        }
    }   $holiday = CompanyHoliday::create([
            'name' => $request->holidayName,
    public function addHoliday(Request $request)
    {       'description' => $request->holidayDescription
        $request->validate([
            'holidayName' => 'required|string|max:255',
            'holidayDate' => 'required|date',
            'holidayDescription' => 'nullable|string'
        ]); 'message' => 'Holiday added successfully',
            'data' => $holiday
        try {
            CompanyHoliday::create([
                'name' => $request->holidayName,
                'date' => $request->holidayDate,
                'description' => $request->holidayDescription
            ]);ype = LeaveType::findOrFail($id);
        $leaveType->delete();
            return response()->json([
                'success' => true,
                'message' => 'Holiday added successfully'
            ]);ssage' => 'Leave type deleted successfully'
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding holiday: ' . $e->getMessage()
            ], 500);
        }holiday = CompanyHoliday::findOrFail($id);
    }   $holiday->delete();

    public function index()        return response()->json([









}    }        return view('settings.system.working-day', compact('workingDays', 'leaveTypes', 'companyHolidays'));        $companyHolidays = CompanyHoliday::all();        $leaveTypes = LeaveType::all();        $workingDays = WorkingDay::all();    {            'success' => true,
            'message' => 'Holiday deleted successfully'
        ]);
    }
}
