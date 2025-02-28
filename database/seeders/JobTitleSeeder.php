<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobTitle;
use App\Models\Department;

class JobTitleSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            'Engineering' => [
                'Frontend Developer',
                'Backend Developer',
                'Full Stack Developer',
                'DevOps Engineer'
            ],
            'Design' => [
                'UI Designer',
                'UX Designer',
                'Graphic Designer'
            ],
            'Marketing' => [
                'Marketing Manager',
                'Content Writer',
                'SEO Specialist'
            ]
        ];

        foreach ($departments as $deptName => $titles) {
            $department = Department::firstOrCreate(['name' => $deptName]);
            
            foreach ($titles as $title) {
                JobTitle::firstOrCreate([
                    'name' => $title,
                    'department_id' => $department->id
                ]);
            }
        }
    }
}
