<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LeavePlan;
use Carbon\Carbon;

class LeavePlanSeeder extends Seeder
{
    public function run()
    {
        // Contoh cuti yang sudah diajukan
        $leavePlans = [
            [
                'user_id' => 1, // Sesuaikan dengan ID user yang ada
                'leave_type_id' => 1, // Sesuaikan dengan ID leave type yang ada
                'start_date' => '2024-03-20',
                'end_date' => '2024-03-22',
                'description' => 'Cuti tahunan untuk acara keluarga',
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'leave_type_id' => 1,
                'start_date' => '2024-04-10',
                'end_date' => '2024-04-12',
                'description' => 'Cuti untuk urusan pribadi',
                'status' => 'pending',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'leave_type_id' => 2,
                'start_date' => '2024-05-15',
                'end_date' => '2024-05-17',
                'description' => 'Cuti sakit',
                'status' => 'approved',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($leavePlans as $plan) {
            LeavePlan::create($plan);
        }
    }
}
