<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceCenterActivity;

class ServiceCenterActivitySeeder extends Seeder
{
    public function run()
    {
        // สร้างข้อมูลศูนย์บริการ
        $centers = [
            // กาฬสินธุ์
            [
                'center_name' => 'กาฬสินธุ์ 1',
                'province_id' => 1
            ],
            [
                'center_name' => 'กุฉินารายณ์',
                'province_id' => 1
            ],
            [
                'center_name' => 'สมเด็จ',
                'province_id' => 1
            ],


            // ขอนแก่น
            [
                'center_name' => 'ขอนแก่น 1',
                'province_id' => 2
            ],
            [
                'center_name' => 'ศูนย์ราชการ ขอนแก่น',
                'province_id' => 2
            ],
            [
                'center_name' => 'บ้านไผ่ 1',
                'province_id' => 2
            ],
            [
                'center_name' => 'พล',
                'province_id' => 2
            ],
            [
                'center_name' => 'ชุมแพ 1',
                'province_id' => 2
            ],
            [
                'center_name' => 'น้ำพอง',
                'province_id' => 2
            ],
            [
                'center_name' => 'กระนวน',
                'province_id' => 2
            ],
            [
                'center_name' => 'หนองเรือ',
                'province_id' => 2
            ],


            // หนองคาย
            [
                'center_name' => 'หนองคาย 1',
                'province_id' => 3
            ],
            [
                'center_name' => 'ท่าบ่อ',
                'province_id' => 3
            ],
            [
                'center_name' => 'โพนพิสัย',
                'province_id' => 3
            ],


            // นครพนม
            [
                'center_name' => 'นครพนม 1',
                'province_id' => 4
            ],
            [
                'center_name' => 'ธาตุพนม',
                'province_id' => 4
            ],


            // หนองบัวลำภู
            [
                'center_name' => 'หนองบัวลำภู 1',
                'province_id' => 5
            ],


             // บึงกาฬ
             [
                'center_name' => 'บึงกาฬ 1',
                'province_id' => 6
            ],

             // มหาสารคาม
             [
                'center_name' => 'มหาสารคาม 1',
                'province_id' => 7
            ],
            [
                'center_name' => 'พยัคฆภูมิพิสัย',
                'province_id' => 7
            ],
            [
                'center_name' => 'โกสุมพิสัย',
                'province_id' => 7
            ],
            [
                'center_name' => 'มหาสารคาม',
                'province_id' => 7
            ],

            // มุกดาหาร
            [
                'center_name' => 'มุกดาหาร 1',
                'province_id' => 8
            ],
            [
                'center_name' => 'มุกดาหาร 2',
                'province_id' => 8
            ],

            // ร้อยเอ็ด
            [
                'center_name' => 'ร้อยเอ็ด 1',
                'province_id' => 9
            ],
            [
                'center_name' => 'โพนทอง',
                'province_id' => 9
            ],
            [
                'center_name' => 'สุวรรณภูมิ',
                'province_id' => 9
            ],

            // เลย
            [
                'center_name' => 'เลย 1',
                'province_id' => 10
            ],
            [
                'center_name' => 'เชียงคาน',
                'province_id' => 10
            ],
            [
                'center_name' => 'วังสะพุง',
                'province_id' => 10
            ],
            [
                'center_name' => 'ด่านซ้าย',
                'province_id' => 10
            ],

            
        // สกลนคร	
        [
            'center_name' => 'สกลนคร 1',
            'province_id' => 11
        ],
        [
            'center_name' => 'พังโคน',
            'province_id' => 11
        ],
        [
            'center_name' => 'วานรนิวาส',
            'province_id' => 11
        ],
        [
            'center_name' => 'สว่างแดนดิน',
            'province_id' => 11
        ],
        
        // อุดรธานี	
        [
            'center_name' => 'อุดรธานี 1',
            'province_id' => 12
        ],
        [
            'center_name' => 'พังโคน',
            'province_id' => 12
        ],
        [
            'center_name' => 'บ้านผือ',
            'province_id' => 12
        ],

        // ชัยภูมิ
        [
            'center_name' => 'ชัยภูมิ 1',
            'province_id' => 13
        ],
        [
            'center_name' => 'จัตุรัส',
            'province_id' => 13
        ],
        [
            'center_name' => 'ภูเขียว',
            'province_id' => 13
        ],

        // นครราชสีมา
        [
            'center_name' => 'นครราชสีมา 1',
            'province_id' => 14
        ],
        [
            'center_name' => 'ปากช่อง 1',
            'province_id' => 14
        ],
        [
            'center_name' => 'บัวใหญ่',
            'province_id' => 14
        ],
        [
            'center_name' => 'สีคิ้ว',
            'province_id' => 14
        ],
        [
            'center_name' => 'ปักธงชัย',
            'province_id' => 14
        ],
        [
            'center_name' => 'พิมาย',
            'province_id' => 14
        ],
        [
            'center_name' => 'เขตอุตสาหกรรมสุรนารี',
            'province_id' => 14
        ],

        // บุรีรัมย์
        [
            'center_name' => 'บุรีรัมย์ 1',
            'province_id' => 15
        ],
        [
            'center_name' => 'ประโคนชัย',
            'province_id' => 15
        ],
        [
            'center_name' => 'นางรอง',
            'province_id' => 15
        ],
        [
            'center_name' => 'สตึก',
            'province_id' => 15
        ],

         // ยโสธร
         [
            'center_name' => 'ยโสธร 1',
            'province_id' => 16
        ],
        [
            'center_name' => 'เลิงนกทา',
            'province_id' => 16
        ],

         // ศรีสะเกษ
         [
            'center_name' => 'ศรีสะเกษ 1',
            'province_id' => 17
        ],
        [
            'center_name' => 'กันทรลักษ์',
            'province_id' => 17
        ],
        [
            'center_name' => 'อุทุมพรพิสัย',
            'province_id' => 17
        ],

        // สุรินทร์
        [
            'center_name' => 'สุรินทร์ 1',
            'province_id' => 18
        ],
        [
            'center_name' => 'ปราสาท',
            'province_id' => 18
        ],
        [
            'center_name' => 'ท่าตูม',
            'province_id' => 18
        ],

        // อำนาจเจริญ
        [
            'center_name' => 'อำนาจเจริญ 1',
            'province_id' => 19
        ],

        // อุบลราชธานี
        [
            'center_name' => 'อุบลราชธานี 1',
            'province_id' => 20
        ],
        [
            'center_name' => 'เดชอุดม',
            'province_id' => 20
        ],
        [
            'center_name' => 'พิบูลมังสาหาร',
            'province_id' => 20
        ],

        [
            'center_name' => 'วารินชำราบ',
            'province_id' => 20
        ],
        [
            'center_name' => 'ตระการพืชผล',
            'province_id' => 20
        ],
        
            
        ];

        foreach ($centers as $center) {
            ServiceCenterActivity::create($center);
        }
    }
}