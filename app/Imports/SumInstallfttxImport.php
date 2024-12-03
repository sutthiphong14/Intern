<?php

namespace App\Imports;

use App\Models\SumInstallfttx;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithLimit;

class SumInstallfttxImport implements ToCollection, WithStartRow, WithLimit
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
        return 69; // อ่าน 63 แถว
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($this->isValidRow($row[4])) {
                $this->saveToSumInstallfttx($row);
            }
        }
    }

    private function isValidRow($columnValue): bool
    {
        $validKeywords = [
            'รวม',
          
        ];

        foreach ($validKeywords as $keyword) {
            if (strpos($columnValue, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    private function saveToSumInstallfttx($row)
    {
        SumInstallfttx::create([
            'sum_installation_center' => $row[4],
            'sum_num_of_circuits' => $this->cleanNumber($row[5]), // ใช้ cleanNumber ที่ column 5
            'sum_total_preparation_time_days' => $this->cleanNumber($row[6]), // ใช้ cleanNumber ที่ column 6
            'sum_total_processing_time_days' => $this->cleanNumber($row[7]), // ใช้ cleanNumber ที่ column 7
            'sum_sdp_odp_deadline_days' => $this->cleanNumber($row[8]), // ใช้ cleanNumber ที่ column 8
            'sum_wiring_time_days' => $this->cleanNumber($row[9]), // ใช้ cleanNumber ที่ column 9
            'sum_config_nms_days' => $this->cleanNumber($row[10]), // ใช้ cleanNumber ที่ column 10
            'sum_technician_appointment_and_scheduling_time_days' => $this->cleanNumber($row[11]), // ใช้ cleanNumber ที่ column 11
            'sum_customer_waiting_time_days' => $this->cleanNumber($row[12]), // ใช้ cleanNumber ที่ column 12
            'sum_cable_pulling_and_ont_installation_time_days' => $this->cleanNumber($row[13]), // ใช้ cleanNumber ที่ column 13
            'sum_closing_work_time_days' => $this->cleanNumber($row[14]), // ใช้ cleanNumber ที่ column 14
            'sum_total_average_time_per_circuit_days' => $this->cleanNumber($row[15]), // ใช้ cleanNumber ที่ column 15
            'sum_num_of_circuits_installed_within_3_days' => $this->cleanNumber($row[16]), // ใช้ cleanNumber ที่ column 16
            'sum_installation_percentage_within_3_days' => $this->cleanNumber($row[17]), // ใช้ cleanNumber ที่ column 17
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
