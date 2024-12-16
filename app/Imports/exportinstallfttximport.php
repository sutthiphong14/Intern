<?php

namespace App\Imports;

use App\Models\Exportinstllfttx;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithLimit;
use Maatwebsite\Excel\Concerns\WithStartRow;

class exportinstallfttximport implements ToCollection,WithStartRow, WithLimit
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
        return 91; // อ่าน 63 แถว
    }
    public function collection(Collection $row)
    {
        foreach ($row as $row) {
            $this->saveToExportinstallfttx($row);
        }
        
    }

    private function saveToExportinstallfttx($row)
    {
        Exportinstllfttx::create([
            'export_region' => $row[1],
            'export_department' => $row[2],
            'export_section' => $row[3],
            'export_installation_center' => $row[4],
            'export_num_of_circuits' => $this->cleanNumber($row[5]), // ใช้ cleanNumber ที่ column 5
            'export_total_preparation_time_days' => $this->cleanNumber($row[6]), // ใช้ cleanNumber ที่ column 6
            'export_total_processing_time_days' => $this->cleanNumber($row[7]), // ใช้ cleanNumber ที่ column 7
            'export_sdp_odp_deadline_days' => $this->cleanNumber($row[8]), // ใช้ cleanNumber ที่ column 8
            'export_wiring_time_days' => $this->cleanNumber($row[9]), // ใช้ cleanNumber ที่ column 9
            'export_config_nms_days' => $this->cleanNumber($row[10]), // ใช้ cleanNumber ที่ column 10
            'export_technician_appointment_and_scheduling_time_days' => $this->cleanNumber($row[11]), // ใช้ cleanNumber ที่ column 11
            'export_customer_waiting_time_days' => $this->cleanNumber($row[12]), // ใช้ cleanNumber ที่ column 12
            'export_cable_pulling_and_ont_installation_time_days' => $this->cleanNumber($row[13]), // ใช้ cleanNumber ที่ column 13
            'export_closing_work_time_days' => $this->cleanNumber($row[14]), // ใช้ cleanNumber ที่ column 14
            'export_total_average_time_per_circuit_days' => $this->cleanNumber($row[15]), // ใช้ cleanNumber ที่ column 15
            'export_num_of_circuits_installed_within_3_days' => $this->cleanNumber($row[16]), // ใช้ cleanNumber ที่ column 16
            'export_installation_percentage_within_3_days' => $this->cleanNumber($row[17]), // ใช้ cleanNumber ที่ column 17
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
