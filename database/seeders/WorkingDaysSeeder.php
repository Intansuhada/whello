<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkingDay;

class WorkingDaysSeeder extends Seeder
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
            WorkingDay::updateOrCreate(
                ['day_name' => $day],
                [
                    'is_working_day' => in_array($day, ['Saturday', 'Sunday']) ? false : true,
                    'morning_start_time' => '09:00',
                    'morning_end_time' => '12:00',
                    'afternoon_start_time' => '13:00',
                    'afternoon_end_time' => '17:00'
                ]
            );
        }
    }
}
