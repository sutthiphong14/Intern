<?php

namespace App\Http\Controllers;

use App\Imports\Installfttx as ImportsInstallfttx;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    // ฟังก์ชั่นสำหรับการนำเข้าไฟล์ Excel
    public function import(Request $request)
    {
        // ตรวจสอบไฟล์ที่อัปโหลด
        $request->validate([
            'import_file' => 'required|file|mimes:xlsx,xls',
            'month' => 'required|string',  // ตรวจสอบ month ว่ามีการกรอก
            'year' => 'required|string'    // ตรวจสอบ year ว่ามีการกรอก
        ]);

        // สร้างข้อมูลเดือนและปีจากฟอร์ม
        $month = $request->month;
        $year = $request->year;

        // นำเข้าไฟล์ Excel โดยใช้ Import Class และส่งค่าเดือนและปีไปใน constructor
        Excel::import(new ImportsInstallfttx($month, $year), $request->file('import_file'));

        // คืนค่ากลับไปที่หน้าก่อนหน้า และแสดงข้อความว่า import เสร็จสมบูรณ์
        return redirect()->back()->with('status', 'Import done!!!');
    }
}


