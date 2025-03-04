<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            'Engineering',
            'Marketing',
            'Sales',
            'Human Resources',
            'Finance',
            'Operations',
            'Product',
            'Customer Support'
        ];

        foreach ($departments as $department) {
            Department::create(['name' => $department]);
        }
    }
}
