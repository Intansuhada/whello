public function calendar()
{
    $year = request('year', now()->year);
    $months = [];
    
    // Get leave counts
    $user = auth()->user();
    $rejectedLeaves = DB::table('leave_plans')
        ->where('user_id', $user->id)
        ->where('status', 'rejected')
        ->count();
        
    $approvedLeaves = DB::table('leave_plans')
        ->where('user_id', $user->id)
        ->where('status', 'approved')
        ->count();
        
    $pendingLeaves = DB::table('leave_plans')
        ->where('user_id', $user->id)
        ->where('status', 'pending')
        ->count();

    // Existing calendar logic...
    // ...

    return view('settings.leave.calendar', compact(
        'months',
        'year',
        'holidays',
        'leaveDays',
        'rejectedLeaves',
        'approvedLeaves',
        'pendingLeaves'
    ));
}

public function store(Request $request)
{
    // ...existing validation and store logic...

    try {
        DB::table('leave_plans')->insert([
            'user_id' => auth()->id(),
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'description' => $request->description,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('settings.leave.calendar')
            ->with('success', 'Leave request has been successfully submitted!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to submit leave request. Please try again.');
    }
}
