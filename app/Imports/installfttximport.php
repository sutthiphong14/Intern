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
            'num_of_circuits' => $row[5],
            'total_preparation_time_days' => $this->cleanNumber($row[6]),
            'total_processing_time_days' => $this->cleanNumber($row[7]),
            'sdp_odp_deadline_days' => $row[8],
            'wiring_time_days' => $row[9],
            'config_nms_days' => $row[10],
            'technician_appointment_and_scheduling_time_days' => $row[11],
            'customer_waiting_time_days' => $row[12],
            'cable_pulling_and_ont_installation_time_days' => $row[13],
            'closing_work_time_days' => $row[14],
            'total_average_time_per_circuit_days' => $row[15],
            'num_of_circuits_installed_within_3_days' => $row[16],
            'installation_percentage_within_3_days' => $row[17],
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    private function cleanNumber($value)
    {
        return str_replace(',', '', $value);
    }
}
