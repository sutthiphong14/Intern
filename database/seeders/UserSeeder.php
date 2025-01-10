<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user with full permissions
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'emp_id' => '00001',
            'department' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin_password'),
            'permission' => json_encode([
                'manage_users' => true,
                'manage_dashboard' => true,
                'manage_newsfeed' => true
            ]),
            
        ]);
    }
}