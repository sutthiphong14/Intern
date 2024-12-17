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
    protected $counter = 2; // ตัวนับสำหรับเพิ่ม 1 และ 2

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
        return 91; // อ่าน 91 แถว
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($this->isValidRow($row[4])) {
                // ตรวจสอบและเพิ่มเลข 1, 2 ถ้าเป็นคำว่า "รวม"
                $row[4] = $this->adjustSumValue($row[4]);
                $this->saveToSumInstallfttx($row);
            }
        }
    }

    private function isValidRow($columnValue): bool
    {
        $validKeywords = ['รวม'];

        foreach ($validKeywords as $keyword) {
            if (strpos($columnValue, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    private function adjustSumValue($value)
    {
        // ถ้าค่าเป็น "รวม" เท่านั้น เพิ่มเลข 1 หรือ 2 ตามลำดับ
        if ($value === 'รวม') {
            $value .= ' ' . $this->counter; // เพิ่มเลข 1 หรือ 2 ต่อท้าย
            $this->counter++; // เพิ่มตัวนับ
        }

        return $value;
    }

    private function saveToSumInstallfttx($row)
    {
        SumInstallfttx::create([
            'sum_installation_center' => $row[4],
            'sum_num_of_circuits' => $this->cleanNumber($row[5]),
            'sum_total_preparation_time_days' => $this->cleanNumber($row[6]),
            'sum_total_processing_time_days' => $this->cleanNumber($row[7]),
            'sum_sdp_odp_deadline_days' => $this->cleanNumber($row[8]),
            'sum_wiring_time_days' => $this->cleanNumber($row[9]),
            'sum_config_nms_days' => $this->cleanNumber($row[10]),
            'sum_technician_appointment_and_scheduling_time_days' => $this->cleanNumber($row[11]),
            'sum_customer_waiting_time_days' => $this->cleanNumber($row[12]),
            'sum_cable_pulling_and_ont_installation_time_days' => $this->cleanNumber($row[13]),
            'sum_closing_work_time_days' => $this->cleanNumber($row[14]),
            'sum_total_average_time_per_circuit_days' => $this->cleanNumber($row[15]),
            'sum_num_of_circuits_installed_within_3_days' => $this->cleanNumber($row[16]),
            'sum_installation_percentage_within_3_days' => $this->cleanNumber($row[17]),
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    private function cleanNumber($value)
    {
        $value = trim($value);
        $value = str_replace(',', '', $value);

        if (is_numeric($value)) {
            return floatval($value);
        } else {
            return 0;
        }
    }
}
