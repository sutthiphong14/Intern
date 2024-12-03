<?php

namespace App\Imports;

use App\Models\Installfttx;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithLimit;

class InstallfttxImport implements ToCollection, WithStartRow, WithLimit
{
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
        return 64; // อ่าน 63 แถว
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!empty($row[2])) {
                $this->saveToInstallfttx($row);
            }
        }
    }

    private function saveToInstallfttx($row)
    {
        Installfttx::create([
            'region' => $row[1],
            'department' => $row[2],
            'section' => $row[3],
            'installation_center' => $row[4],
            'num_of_circuits' => $this->cleanNumber($row[5]), // ใช้ cleanNumber ที่ column 5
            'total_preparation_time_days' => $this->cleanNumber($row[6]), // ใช้ cleanNumber ที่ column 6
            'total_processing_time_days' => $this->cleanNumber($row[7]), // ใช้ cleanNumber ที่ column 7
            'sdp_odp_deadline_days' => $this->cleanNumber($row[8]), // ใช้ cleanNumber ที่ column 8
            'wiring_time_days' => $this->cleanNumber($row[9]), // ใช้ cleanNumber ที่ column 9
            'config_nms_days' => $this->cleanNumber($row[10]), // ใช้ cleanNumber ที่ column 10
            'technician_appointment_and_scheduling_time_days' => $this->cleanNumber($row[11]), // ใช้ cleanNumber ที่ column 11
            'customer_waiting_time_days' => $this->cleanNumber($row[12]), // ใช้ cleanNumber ที่ column 12
            'cable_pulling_and_ont_installation_time_days' => $this->cleanNumber($row[13]), // ใช้ cleanNumber ที่ column 13
            'closing_work_time_days' => $this->cleanNumber($row[14]), // ใช้ cleanNumber ที่ column 14
            'total_average_time_per_circuit_days' => $this->cleanNumber($row[15]), // ใช้ cleanNumber ที่ column 15
            'num_of_circuits_installed_within_3_days' => $this->cleanNumber($row[16]), // ใช้ cleanNumber ที่ column 16
            'installation_percentage_within_3_days' => $this->cleanNumber($row[17]), // ใช้ cleanNumber ที่ column 17
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    private function cleanNumber($value)
    {
        // ลบช่องว่างที่ไม่จำเป็นและเครื่องหมายจุลภาค
        $value = trim($value); // ลบช่องว่าง
        $value = str_replace(',', '', $value); // ลบเครื่องหมายจุลภาค

        // ตรวจสอบว่าเป็นตัวเลขที่สามารถแปลงได้หรือไม่
        if (is_numeric($value)) {
            return floatval($value); // แปลงเป็น float
        } else {
            return 0; // หากไม่ใช่ตัวเลข คืนค่า 0
        }
    }
}
