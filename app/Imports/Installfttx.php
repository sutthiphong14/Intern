<?php

namespace App\Imports;

use App\Models\Installfttx as ModelsInstallfttx;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithLimit;

class Installfttx  implements ToCollection, WithStartRow, WithLimit
{
    /**
     * @param Collection $collection
     */
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }


    public function startRow(): int
    {
        return 4; // เริ่มที่แถว 4
    }

    public function limit(): int
    {
        return 63; // อ่าน 10 แถว
    }


    public function collection(Collection $rows)
    {
        //
        foreach ($rows as $row) {
            // ข้ามแถวที่คอลัมน์ 1 ว่าง หรือคอลัมน์ 2 ไม่ใช่ตัวเลข
            if (empty($row[2])) {
                continue; // ข้ามแถวนี้แล้วไปแถวถัดไป
            }


            ModelsInstallfttx::create([
                'region' => $row[1],  // แถวที่ 1

                'department' => $row[2],  // แถวที่ 2

                'section' => $row[3],  // แถวที่ 3

                'installation_center' => $row[4],  // แถวที่ 4

                'num_of_circuits' => $row[5],  // แถวที่ 5

                'total_preparation_time_days' => str_replace(',', '', $row[6]),  // แถวที่ 6

                'total_processing_time_days' => str_replace(',', '', $row[7]),

                'sdp_odp_deadline_days' => $row[8],  // แถวที่ 8

                'wiring_time_days' => $row[9],  // แถวที่ 9

                'config_nms_days' => $row[10],  // แถวที่ 10

                'technician_appointment_and_scheduling_time_days' => $row[11],  // แถวที่ 11

                'customer_waiting_time_days' => $row[12],  // แถวที่ 12

                'cable_pulling_and_ont_installation_time_days' => $row[13],  // แถวที่ 13

                'closing_work_time_days' => $row[14],  // แถวที่ 14

                'total_average_time_per_circuit_days' => $row[15],  // แถวที่ 15

                'num_of_circuits_installed_within_3_days' => $row[16],  // แถวที่ 16

                'installation_percentage_within_3_days' => $row[17],  // แถวที่ 17

                'month' => $this->month,  // ส่ง month ที่ได้รับมาจาก controller
                'year' => $this->year,    // ส่ง year ที่ได้รับมาจาก controller


            ]);
        }
    }
}
