<?php

namespace App\Http\Controllers;


use App\Imports\InstallfttxImport;
use App\Imports\SumInstallfttxImport;
use App\Imports\totalfttximport;
use App\Models\Installfttx;
use App\Models\suminstallfttx;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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

        Excel::import(new totalfttximport($month, $year), $request->file('import_file'));

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
     

        // ดึงข้อมูลจาก model SumInstallfttx ที่มีค่า 'sum_installation_center' เป็น "รวม ภน"
        // และกรองค่าซ้ำ
        $installationCenters = SumInstallfttx::whereIn('sum_installation_center', ['รวม ภน.2.1', 'รวม ภน.2.2'])
            ->distinct() // กรองค่าซ้ำ
            ->pluck('sum_installation_center');

        $presenct_data = SumInstallfttx::distinct() // กรองค่าซ้ำ
            ->pluck('sum_installation_center');
        $monthMapping = [
            'มกราคม' => 1,
            'กุมภาพันธ์' => 2,
            'มีนาคม' => 3,
            'เมษายน' => 4,
            'พฤษภาคม' => 5,
            'มิถุนายน' => 6,
            'กรกฎาคม' => 7,
            'สิงหาคม' => 8,
            'กันยายน' => 9,
            'ตุลาคม' => 10,
            'พฤศจิกายน' => 11,
            'ธันวาคม' => 12,
        ];

        // ดึงข้อมูลจาก SumInstallfttx
        $currentYear = Carbon::now()->year; // ดึงปีปัจจุบันจาก Carbon

        // ดึงข้อมูลที่มีปีตรงกับปีปัจจุบัน
        $sumInstallfttx = SumInstallfttx::where('year', $currentYear)->get();


        // ตรวจสอบข้อมูลที่ดึงมาจากฐานข้อมูล
        // dd($sumInstallfttx); 

        // แปลงชื่อเดือนเป็นหมายเลขเดือน
        $sumInstallfttx = $sumInstallfttx->map(function ($item) use ($monthMapping) {
            $item->month_number = $monthMapping[$item->month] ?? null; // แปลงชื่อเดือนเป็นหมายเลขเดือน
            return $item;
        });

        // หาค่าเดือนล่าสุด (โดยใช้ max จากหมายเลขเดือน)
        $latestMonthNumber = $sumInstallfttx->max('month_number');

        // กรองข้อมูลที่มีเดือนล่าสุด
        $latestMonthData = $sumInstallfttx->where('month_number', $latestMonthNumber);
        // ตรวจสอบข้อมูลใน $latestMonthData
       
        

        // คืนค่าผลลัพธ์ไปยัง view พร้อมกับทั้งสามตัวแปร
        return view('report.viewInstallFTTx', compact( 'installationCenters', 'latestMonthData'));
    }




    public function dataprovin()
    {
        $data = Installfttx::all(); // ใช้ all() เพื่อดึงข้อมูลทั้งหมดจากตาราง
        return view('report.viewInstallFTTxprovin', compact('data'));
    }

    public function sortprovin($section, $year)
    {
        // ดึงข้อมูลจากตาราง suminstallfttx โดยเปรียบเทียบ section กับ sum_installation_center และ year
        $sumData = SumInstallfttx::where('sum_installation_center', 'LIKE', "%$section%")
                                 ->where('year', '=', $year)  // เปรียบเทียบปี
                                 ->get();
                                 

                                 
    
        // ส่งข้อมูลไปยัง view
        return view('report.viewinstallFTTxprovin', compact('sumData', 'section', 'year'));
    }

    public function sortcenter($section, $year, $month)
    {
        // ตัดคำว่า "รวม " ออกจากค่าของ $section
        $section = str_replace('รวม ', '', $section);
    
        // ดึงข้อมูลจากตาราง installfttx โดยเปรียบเทียบ section, year และ month
        $installData = Installfttx::where('section', 'LIKE', "%$section%")  // กรองตาม section
                                  ->where('year', '=', $year)               // กรองตาม year
                                  ->where('month', '=', $month)             // กรองตาม month
                                  ->get();
                            
    
        // ส่งข้อมูลไปยัง view
        return view('report.viewInstallFTTxcenter', compact('installData', 'section', 'year', 'month'));
    }
    
    
}
