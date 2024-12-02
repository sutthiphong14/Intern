<?php

namespace App\Http\Controllers;


use App\Imports\InstallfttxImport;
use App\Imports\SumInstallfttxImport;
use App\Models\Installfttx;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    

    // ฟังก์ชั่นสำหรับการนำเข้าไฟล์ Excel
    function import(Request $request)
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
        Excel::import(new InstallfttxImport($month, $year), $request->file('import_file'));

        Excel::import(new SumInstallfttxImport($month, $year), $request->file('import_file'));

        // คืนค่ากลับไปที่หน้าก่อนหน้า และแสดงข้อความว่า import เสร็จสมบูรณ์
        return redirect()->back()->with('status', 'Import done!!!');
       

    }

    function datacenter()
    {
        // ดึงข้อมูลจากฐานข้อมูล
        $data = Installfttx::all(); // ใช้ all() เพื่อดึงข้อมูลทั้งหมดจากตาราง

        // ส่งข้อมูลไปยัง view
        return view('report.viewInstallFTTxcenter', compact('data'));
    }

    public function datainstallfttx()
    {
        // ดึงข้อมูลคอลัมน์ 'section' โดยกรองค่าซ้ำ
        $sections = Installfttx::distinct()->pluck('section');
    
        // คืนค่าผลลัพธ์
        return view('report.viewInstallFTTx',compact('sections'));
    }

    public function dataprovin(){
        $data = Installfttx::all(); // ใช้ all() เพื่อดึงข้อมูลทั้งหมดจากตาราง
        return view('report.viewInstallFTTxprovin', compact('data'));
    }

    public function sortprovin($section)
    {
        // ดึงข้อมูลที่ตรงกับ section จากฐานข้อมูล
        $dataprovin = Installfttx::where('section', $section)->get();

        // แสดงข้อมูลใน view
        return view('report.viewinstallFTTxprovin', compact('dataprovin', 'section'));
    }
    

    
    
}
