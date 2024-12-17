<?php

namespace App\Exports;

use App\Models\Exportinstllfttx;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ExportFttxReport implements FromView
{
    protected $year;
    protected $month;

    // สร้าง constructor เพื่อรับ year และ month
    public function __construct($year, $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    // ฟังก์ชัน view สำหรับแสดงผลใน Excel
    public function view(): View
    {
        // ดึงข้อมูลจากฐานข้อมูลที่ตรงกับ year และ month
        $data = Exportinstllfttx::where('year', $this->year)
            ->where('month', $this->month)
            ->get();

        // ส่งข้อมูลไปยัง view
        return view('report.export', [
            'data' => $data,
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }
}
