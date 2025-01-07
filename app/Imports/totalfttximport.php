<?php

namespace App\Imports;

use App\Models\TotalInstallFTTx;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TotalFttxImport implements ToCollection, WithStartRow
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

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // ตรวจสอบว่าแถวนี้มีคำว่า "รวม" ในคอลัมน์ที่ 4 และไม่มีค่าอื่นตามหลัง
            if ($this->isSummaryRow($row[4])) {
                $this->saveToTotalInstallfttx($row);
            }
        }
    }

    private function isSummaryRow($value): bool
    {
        // ตรวจสอบว่าค่าในคอลัมน์ 4 คือ "รวม" และไม่มีข้อความอื่นตามหลัง
        $value = trim($value); // ลบช่องว่างรอบข้าง
        return $value === 'รวม'; // ตรวจสอบว่าค่าตรงกับคำว่า "รวม" อย่างเดียว
    }

    private function saveToTotalInstallfttx($row)
    {
        TotalInstallFTTx::create([
            'total_installation_center' => $row[4], // จาก column 4
            'total_num_of_circuits' => $this->cleanNumber($row[5]), // จาก column 5
            'total_total_preparation_time_days' => $this->cleanNumber($row[6]), // จาก column 6
            'total_total_processing_time_days' => $this->cleanNumber($row[7]), // จาก column 7
            'total_sdp_odp_deadline_days' => $this->cleanNumber($row[8]), // จาก column 8
            'total_wiring_time_days' => $this->cleanNumber($row[9]), // จาก column 9
            'total_config_nms_days' => $this->cleanNumber($row[10]), // จาก column 10
            'total_technician_appointment_and_scheduling_time_days' => $this->cleanNumber($row[11]), // จาก column 11
            'total_customer_waiting_time_days' => $this->cleanNumber($row[12]), // จาก column 12
            'total_cable_pulling_and_ont_installation_time_days' => $this->cleanNumber($row[13]), // จาก column 13
            'total_closing_work_time_days' => $this->cleanNumber($row[14]), // จาก column 14
            'total_total_average_time_per_circuit_days' => $this->cleanNumber($row[15]), // จาก column 15
            'total_num_of_circuits_installed_within_3_days' => $this->cleanNumber($row[16]), // จาก column 16
            'total_installation_percentage_within_3_days' => $this->cleanNumber($row[17]), // จาก column 17
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
