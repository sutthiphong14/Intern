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
        return 64; // อ่าน 63 แถว
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
            'รวม บภน.2.1 (กส.)', 'รวม บภน.2.1 (ขก.)', 'รวม บภน.2.1 (มค.)',
            'รวม บภน.2.1 (รอ.)', 'รวม บภน.2.2 (นค.)', 'รวม บภน.2.2 (นพ.)',
            'รวม บภน.2.2 (นภ.)', 'รวม บภน.2.2 (บก.)', 'รวม บภน.2.2 (มห.)',
            'รวม บภน.2.2 (ลย.)', 'รวม บภน.2.2 (สน.)', 'รวม บภน.2.2 (อด.)'
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
            'sum_num_of_circuits' => $row[5],
            'sum_total_preparation_time_days' => $this->cleanNumber($row[6]),
            'sum_total_processing_time_days' => $this->cleanNumber($row[7]),
            'sum_sdp_odp_deadline_days' => $row[8],
            'sum_wiring_time_days' => $row[9],
            'sum_config_nms_days' => $row[10],
            'sum_technician_appointment_and_scheduling_time_days' => $row[11],
            'sum_customer_waiting_time_days' => $row[12],
            'sum_cable_pulling_and_ont_installation_time_days' => $row[13],
            'sum_closing_work_time_days' => $row[14],
            'sum_total_average_time_per_circuit_days' => $row[15],
            'sum_num_of_circuits_installed_within_3_days' => $row[16],
            'sum_installation_percentage_within_3_days' => $row[17],
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    private function cleanNumber($value)
    {
        return str_replace(',', '', $value);
    }
}
