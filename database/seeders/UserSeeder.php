<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['id' => 1, 'name' => 'Administrator'],
            ['id' => 2, 'name' => 'Member'],
        ]);

        Department::insert([
            ['id' => 1, 'name' => 'IT'],
        ]);

        JobTitle::insert([
            ['id' => 1, 'name' => 'Frontend Developer', 'department_id' => 1],
            ['id' => 2, 'name' => 'Backend Developer', 'department_id' => 1],
            ['id' => 3, 'name' => 'Quality Control', 'department_id' => 1],
        ]);

        $admin = User::create([
            'role_id' => 1,
            'username' => 'admin',
            'email' => 'admin@whello.id',
            'password' => 'whello.id',
        ]);

        $admin->profile()->create([
            'name' => 'Administrator',
            'nickname' => 'whello',
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'job_title_id' => 1,
        ]);

        $user = User::create([
            'username' => 'fadlin',
            'email' => 'fadlin.whello@gmail.com',
            'password' => 'whello.id',
        ]);

        $user->profile()->create([
            'name' => 'User',
            'nickname' => 'fadlin',
            'about' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'job_title_id' => 2,
        ]);
    }
}
