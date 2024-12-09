<?php

namespace App\Http\Controllers;


use App\Imports\InstallfttxImport;
use App\Imports\SumInstallfttxImport;
use App\Imports\totalfttximport;
use App\Models\Installfttx;
use App\Models\suminstallfttx;
use App\Models\Totalinstallfttx;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportController extends Controller
{



    public function import(Request $request)
    {
        // ตรวจสอบไฟล์และข้อมูลเดือน ปี
        $request->validate([
            'month' => 'required|string',
            'year' => 'required|string'
        ]);
        $month = $request->month;
        $year = $request->year;
    
        // ตรวจสอบข้อมูลในฐานข้อมูล
        $existingData = Installfttx::where('month', $month)->where('year', $year)->first();
        if ($existingData) {
            // ถ้ามีข้อมูล และผู้ใช้ได้อัพโหลดไฟล์ใหม่
            $filePath = $request->hasFile('import_file') 
                        ? $request->file('import_file')->store('temp') 
                        : null;
    
            // ส่งตัวแปรเพื่อเปิด Modal ในหน้า importdata
            return view('report.importdata', [
                'month' => $month ,
                'year' => $year,
                'filePath' => $filePath,
                'showModal' => true // เพิ่มตัวแปรเพื่อเปิด Modal
            ]);
        }
    
        // ถ้าไม่มีข้อมูลในฐานข้อมูล ให้ทำการนำเข้าไฟล์ใหม่
        if ($request->hasFile('import_file')) {
            Excel::import(new InstallfttxImport($month, $year), $request->file('import_file'));
            Excel::import(new SumInstallfttxImport($month, $year), $request->file('import_file'));
            Excel::import(new TotalfttxImport($month, $year), $request->file('import_file'));
        }
    
        return redirect()->route('viewInstallFTTx')->with('status', 'Import done!!!');
    }
    
    
    
    public function importFile(Request $request)
    {
        // ตรวจสอบการเลือกไฟล์
        $filePath = $request->filePath;
        $month = $request->month;
        $year = $request->year;
        if ($request->file_choice == 'new') {
            // ลบข้อมูลเก่าที่มีเดือนและปีนี้
            Installfttx::where('month', $request->month)->where('year', $request->year)->delete();
            SumInstallfttx::where('month', $request->month)->where('year', $request->year)->delete();
            Totalinstallfttx::where('month', $request->month)->where('year', $request->year)->delete();
          
            // ใช้ไฟล์ที่รับจากฟอร์ม
            Excel::import(new InstallfttxImport($month, $year), $filePath);
            Excel::import(new SumInstallfttxImport($month, $year), $filePath);
            Excel::import(new TotalfttxImport($month, $year), $filePath);
            return redirect()->route('viewInstallFTTx')->with('status', 'เพิ่มไฟล์ใหม่แทนที่แล้ว!!!');
        }
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

    $presenct_data = SumInstallfttx::distinct()
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

    // แปลงชื่อเดือนเป็นหมายเลขเดือน
    $sumInstallfttx = $sumInstallfttx->map(function ($item) use ($monthMapping) {
        $item->month_number = $monthMapping[$item->month] ?? null; // แปลงชื่อเดือนเป็นหมายเลขเดือน
        return $item;
    });

    // หาค่าเดือนล่าสุด (โดยใช้ max จากหมายเลขเดือน)
    $latestMonthNumber = $sumInstallfttx->max('month_number');

    // กรองข้อมูลที่มีเดือนล่าสุด
    $latestMonthData = $sumInstallfttx->where('month_number', $latestMonthNumber);

    // จัดเรียงข้อมูลตาม installation_percentage_within_3_days จากมากไปน้อย
    $sortedDataMax = $latestMonthData
    ->reject(function ($item) {
        return in_array($item->sum_installation_center, ['รวม ภน.2.1', 'รวม ภน.2.2','รวม']);
    })
    ->sortByDesc('sum_installation_percentage_within_3_days')
    ->take(5);

    $sortedDataMin = $latestMonthData
    ->reject(function ($item) {
        return in_array($item->sum_installation_center, ['รวม ภน.2.1', 'รวม ภน.2.2', 'รวม']);
    })
    ->sortBy('sum_installation_percentage_within_3_days') // ใช้ sortBy เพื่อเรียงจากน้อยไปมาก
    ->take(1); // เลือก 1 รายการแรก


    // คืนค่าผลลัพธ์ไปยัง view พร้อมกับทั้งสองตัวแปร
    return view('report.viewInstallFTTx', compact('installationCenters', 'sortedDataMax','latestMonthData','sortedDataMin'));
}

    public function datainstallfttxYear(Request $request)
    {
        // รับค่า year จาก query string, ถ้าไม่มีจะใช้ปีปัจจุบัน
        $year = $request->input('year', Carbon::now()->year); // ค่า default เป็นปีปัจจุบัน

        // ดึงข้อมูลจาก model SumInstallfttx ที่มีค่า 'sum_installation_center' เป็น "รวม ภน"
        $installationCenters = SumInstallfttx::whereIn('sum_installation_center', ['รวม ภน.2.1', 'รวม ภน.2.2'])
            ->distinct() // กรองค่าซ้ำ
            ->pluck('sum_installation_center');

        // ดึงข้อมูลที่มีปีตรงกับค่า year ที่ได้รับ
        $sumInstallfttx = SumInstallfttx::where('year', $year)->get();

        // ถ้าไม่มีข้อมูลในปีนั้น ให้แจ้งเตือน
        if ($sumInstallfttx->isEmpty()) {
            return redirect()->back()->with('alert', 'ไม่มีข้อมูลสำหรับปี ' . $year);
        }

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

        // แปลงชื่อเดือนเป็นหมายเลขเดือน
        $sumInstallfttx = $sumInstallfttx->map(function ($item) use ($monthMapping) {
            $item->month_number = $monthMapping[$item->month] ?? null; // แปลงชื่อเดือนเป็นหมายเลขเดือน
            return $item;
        });

        // หาค่าเดือนล่าสุด (โดยใช้ max จากหมายเลขเดือน)
        $latestMonthNumber = $sumInstallfttx->max('month_number');

        // กรองข้อมูลที่มีเดือนล่าสุด
        $latestMonthData = $sumInstallfttx->where('month_number', $latestMonthNumber);

        // จัดเรียงข้อมูลตาม installation_percentage_within_3_days จากมากไปน้อย
    $sortedDataMax = $latestMonthData
    ->reject(function ($item) {
        return in_array($item->sum_installation_center, ['รวม ภน.2.1', 'รวม ภน.2.2','รวม']);
    })
    ->sortByDesc('sum_installation_percentage_within_3_days')
    ->take(5);

    $sortedDataMin = $latestMonthData
    ->reject(function ($item) {
        return in_array($item->sum_installation_center, ['รวม ภน.2.1', 'รวม ภน.2.2', 'รวม']);
    })
    ->sortBy('sum_installation_percentage_within_3_days') // ใช้ sortBy เพื่อเรียงจากน้อยไปมาก
    ->take(1); // เลือก 1 รายการแรก


    // คืนค่าผลลัพธ์ไปยัง view พร้อมกับทั้งสองตัวแปร
    return view('report.viewInstallFTTx', compact('installationCenters', 'sortedDataMax','latestMonthData','sortedDataMin'));
}








    public function dataprovin()
    {
        $data = Installfttx::all(); // ใช้ all() เพื่อดึงข้อมูลทั้งหมดจากตาราง
        return view('report.viewInstallFTTxprovin', compact('data'));
    }

    public function sortprovin($section, $year)
    {

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

        $sumData = SumInstallfttx::where('sum_installation_center', 'LIKE', "%$section%")
            ->where('year', '=', $year)
            ->get()
            ->map(function ($item) use ($monthMapping) {
                $item->month_number = $monthMapping[$item->month] ?? null; // แปลงชื่อเดือนเป็นหมายเลขเดือน
                return $item;
            })
            ->sortBy('month_number'); // เรียงตามหมายเลขเดือน





        // เตรียมข้อมูลสำหรับกราฟ
        $labels = $sumData->pluck('month'); // ใช้เดือนเป็น label
        $data = $sumData->pluck('sum_installation_percentage_within_3_days'); // ใช้เปอร์เซ็นต์รวม

        return view('report.viewinstallFTTxprovin', compact('sumData', 'labels', 'data', 'section', 'year'));
    }


    public function sortcenter($section, $year, $month)
    {
        $section = str_replace('รวม ', '', $section);

        $columns = [
            'num_of_circuits',
            'total_preparation_time_days',
            'total_processing_time_days',
            'sdp_odp_deadline_days',
            'wiring_time_days',
            'config_nms_days',
            'technician_appointment_and_scheduling_time_days',
            'customer_waiting_time_days',
            'cable_pulling_and_ont_installation_time_days',
            'closing_work_time_days',
            'total_average_time_per_circuit_days',
            'num_of_circuits_installed_within_3_days',
            'installation_percentage_within_3_days',
        ];

        $installData = Installfttx::where('section', 'LIKE', "%$section%")
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->where(function ($query) use ($columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, '!=', 0);
                }
            })
            ->get();


        $labels = $installData->pluck('installation_center'); // ใช้ชื่อของ section หรือ center เป็น label
        $data = $installData->pluck('installation_percentage_within_3_days'); // ใช้เปอร์เซ็นต์การติดตั้ง

        return view('report.viewInstallFTTxcenter', compact('installData', 'labels', 'data', 'section', 'year', 'month'));
    }

    public function getExistingMonths(Request $request)
{
    $year = $request->input('year'); // รับค่าปีจากคำขอ
    $data = Installfttx::where('year', $year) // ดึงเฉพาะปีที่ระบุ
                        ->select('year', 'month')
                        ->get();
    return response()->json($data);
}

}
