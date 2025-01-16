<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProvinceActivity;

class ProvinceActivitySeeder extends Seeder
{
    public function run()
    {
        // สร้างข้อมูลจังหวัด
        $provinces = [
            ['province_name' => 'กาฬสินธุ์'],
            ['province_name' => 'ขอนแก่น'],
            ['province_name' => 'หนองคาย'],
            ['province_name' => 'นครพนม'],
            ['province_name' => 'หนองบัวลำภู'],
            ['province_name' => 'บึงกาฬ'],
            ['province_name' => 'มหาสารคาม'],
            ['province_name' => 'มุกดาหาร'],
            ['province_name' => 'ร้อยเอ็ด'],
            ['province_name' => 'เลย'],
            ['province_name' => 'สกลนคร'],
            ['province_name' => 'อุดรธานี'],
            ['province_name' => 'ชัยภูมิ'],
            ['province_name' => 'นครราชสีมา'],
            ['province_name' => 'บุรีรัมย์'],
            ['province_name' => 'ยโสธร'],
            ['province_name' => 'ศรีสะเกษ'],
            ['province_name' => 'สุรินทร์'],
            ['province_name' => 'อำนาจเจริญ'],
            ['province_name' => 'อุบลราชธานี']
        ];

        foreach ($provinces as $province) {
            ProvinceActivity::create($province);
        }
    }
}