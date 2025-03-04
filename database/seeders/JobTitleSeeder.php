<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobTitle;

class JobTitleSeeder extends Seeder
{
    public function run()
    {
        $jobTitles = [
            'Software Engineer',
            'Product Manager',
            'Marketing Manager',
            'Sales Representative',
            'HR Manager',
            'Financial Analyst',
            'Operations Manager',
            'Customer Support Representative'
        ];

        foreach ($jobTitles as $title) {
            JobTitle::create(['name' => $title]);
        }
    }
}
