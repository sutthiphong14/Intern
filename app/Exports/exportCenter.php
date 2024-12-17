<?php

namespace App\Exports;

use App\Models\Exportinstllfttx;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class exportCenter implements FromView
{
    protected $year;
    protected $month;
    protected $section;

    // สร้าง constructor เพื่อรับ year, month และ section
    public function __construct($year, $month, $section)
    {
        $this->year = $year;
        $this->month = $month;
        $this->section = $section;
    }

    // ฟังก์ชัน view สำหรับแสดงผลใน Excel
    public function view(): View
    {
        // เริ่มต้นสร้าง query
        $query = Exportinstllfttx::where('year', $this->year)
            ->where('month', $this->month);

        // เพิ่มเงื่อนไข if สำหรับ section
        if ($this->section == '2' || $this->section == '3') {
            $query->where('export_region', 'LIKE', "%$this->section%");  // กรณีที่ section เป็น 2 หรือ 3
        } else {
            $query ->where('export_section', $this->section);   // กรณีอื่นๆ ของ section
        }

        // เพิ่มเงื่อนไขเพิ่มเติมตามต้องการ เช่น การกรองสถานะหรือวันที่
        

        // ดึงข้อมูลจากฐานข้อมูลตาม query ที่กรอง
        $data = $query->get();

        // ส่งข้อมูลไปยัง view
        return view('report.export_center', [
            'data' => $data,
            'month' => $this->month,
            'year' => $this->year,
            'section' => $this->section, // ส่ง section ไปยัง view ด้วย
        ]);
    }
}




