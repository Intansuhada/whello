<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkingDay;

class WorkingDaySeeder extends Seeder
{
    public function run()
    {
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
            'Saturday',
            'Sunday'
        ];

        foreach ($days as $day) {
            WorkingDay::create([
                'day_name' => $day,
                'is_working_day' => in_array($day, ['Saturday', 'Sunday']) ? false : true,
                'start_time' => '09:00:00',
                'end_time' => '17:00:00',
            ]);
        }
    }
}
