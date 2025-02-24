<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // สร้างผู้ใช้เริ่มต้น (Admin User) พร้อมกำหนด permission และข้อมูลอื่น ๆ
        User::create([
            'name' => 'Admin User',
            'username' => 'admin',
            'emp_id' => '00001',
            'department' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin_password'),
            'permission' => [
                'adminper_mission' => 1,
                'manage_users' => 1,
                'manage_dashboard' => 1,
                'view_fttx' => 1,
                'managenews_feeds' => 1,
                'manage_banner' => 1,
                'manage_imageevent' => 1,
                'manage_formevent' => 1,
                'form_event' => 1,
                'view_customer' => 1,
            ],
            // 'province_id' => 2, // ต้องแน่ใจว่ามี province_id ที่ถูกต้องในฐานข้อมูล
            // 'center_id' => 5, // ต้องแน่ใจว่ามี center_id ที่ถูกต้องในฐานข้อมูล
            'profile_image' => null, // หรือสามารถใส่ URL รูปภาพเริ่มต้นได้
        ]);
    }
}
