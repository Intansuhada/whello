public function update(Request $request)
{
    try {
        DB::beginTransaction();
        
        foreach ($request->working_days as $id => $day) {
            $workingDay = WorkingDay::findOrFail($id);
            
            // Get the working day status and ensure it's a proper integer value
            $isWorkingDay = isset($day['is_working_day']) ? (int)$day['is_working_day'] : 0;
            
            // Prepare update data
            $updateData = [];
            $updateData['is_working_day'] = $isWorkingDay;
            
            if ($isWorkingDay === 1) {
                // If working day, update all time fields
                $updateData = array_merge($updateData, [
                    'morning_start_time' => !empty($day['morning_start_time']) ? $day['morning_start_time'] : null,
                    'morning_end_time' => !empty($day['morning_end_time']) ? $day['morning_end_time'] : null,
                    'afternoon_start_time' => !empty($day['afternoon_start_time']) ? $day['afternoon_start_time'] : null,
                    'afternoon_end_time' => !empty($day['afternoon_end_time']) ? $day['afternoon_end_time'] : null,
                ]);
            } else {
                // If off day, set all time fields to null
                $updateData = array_merge($updateData, [
                    'morning_start_time' => null,
                    'morning_end_time' => null,
                    'afternoon_start_time' => null,
                    'afternoon_end_time' => null,
                ]);
            }

            // Update the record directly using query builder to avoid model events
            DB::table('working_days')
                ->where('id', $id)
                ->update($updateData);
        }

        DB::commit();
        return redirect()->back()->with('success', 'Working days updated successfully');
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error updating working days: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to update working days: ' . $e->getMessage());
    }
}
