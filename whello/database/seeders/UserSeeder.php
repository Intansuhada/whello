<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Making roles
        Role::insert([
            ['id' => 1, 'name' => 'Administrator'],
            ['id' => 2, 'name' => 'Member'],
        ]);

        // Making super admin account
        User::create([
            'name' => 'Whello Admin',
            'role_id' => 1,
            'email' => 'admin@whello.id',
            'password' => Hash::make('whello.id'),
        ]);

        User::create([
            'name' => 'Whello Member',
            'role_id' => 2,
            'email' => 'fadlin.whello@gmail.com',
            'password' => Hash::make('whello.id'),
        ]);
    }
}
