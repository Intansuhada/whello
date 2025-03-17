<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeaveType;

class LeaveTypeSeeder extends Seeder
{
    public function run()
    {
        $leaveTypes = [
            ['name' => 'Annual Leave', 'code' => 'AL', 'description' => 'Regular annual leave'],
            ['name' => 'Sick Leave', 'code' => 'SL', 'description' => 'Medical leave'],
            ['name' => 'Personal Leave', 'code' => 'PL', 'description' => 'Personal matters']
        ];

        foreach ($leaveTypes as $type) {
            LeaveType::create($type);
        }
    }
}
