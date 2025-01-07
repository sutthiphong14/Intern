<?php

namespace App\Http\Controllers;

use App\Exports\exportCenter;
use App\Exports\ExportFttxReport;
use App\Imports\exportinstallfttximport;
use App\Imports\installfttxImport;
use App\Imports\SumInstallfttxImport;
use App\Imports\totalfttximport;
use App\Models\Exportinstllfttx;
use App\Models\Installfttx;
use App\Models\SumInstallfttx;
use App\Models\Totalinstallfttx;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{



 

    public function import(Request $request)
    {
        // เริ่มต้น transaction
        DB::beginTransaction();

        try {
            // ตรวจสอบไฟล์และข้อมูลเดือน ปี
            $request->validate([
                'month' => 'required|string',
                'year' => 'required|string',
                'import_file' => 'required|mimes:xlsx,xls'  // ตรวจสอบประเภทไฟล์ Excel
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
    
                // ส่งข้อมูลกลับเป็น JSON (เพื่อให้จัดการใน JS)
                return response()->json([
                   
                    'filePath' => $filePath,
                    'showModal' => true,
                    'month' => $month,
                    'year' => $year
                ]);
            }

            // ถ้าไม่มีข้อมูลในฐานข้อมูล ให้ทำการนำเข้าไฟล์ใหม่
            if ($request->hasFile('import_file')) {
                try {
                    // นำเข้าไฟล์ทั้งหมดในครั้งเดียว
                    Excel::import(new installfttxImport($month, $year), $request->file('import_file'));
                    Excel::import(new SumInstallfttxImport($month, $year), $request->file('import_file'));
                    Excel::import(new TotalfttxImport($month, $year), $request->file('import_file'));
                    Excel::import(new exportinstallfttximport($month, $year), $request->file('import_file'));
                } catch (\Exception $e) {
                    // หากเกิดข้อผิดพลาดจะ rollback และไม่บันทึกข้อมูลในฐานข้อมูล
                    DB::rollback();
                    return response()->json([
                        'status' => 'error',    
                        'message' => $e->getMessage(), // แสดงข้อความข้อผิดพลาด
                    ], 400); // รหัส 400 สำหรับข้อผิดพลาด
                }
            }

            // Commit transaction เมื่อทุกอย่างสำเร็จ
            DB::commit();
    
            return response()->json([
                'status' => 'success',
                'redirect_url' => route('viewInstallFTTx'),
                'message' => 'นำเข้าไฟล์สำเร็จ!!!'
            ]);
    
        } catch (\Exception $e) {
            // หากเกิดข้อผิดพลาดที่ไม่เกี่ยวข้องกับการนำเข้าไฟล์
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'เกิดข้อผิดพลาด ' . $e->getMessage()
            ], 500); // รหัส 500 สำหรับข้อผิดพลาดที่ไม่คาดคิด
        }
    }

    public function importFile(Request $request)
    {
        // ตรวจสอบการเลือกไฟล์
        $request->validate([
            'import_file' => 'mimes:xlsx,xls'  // ตรวจสอบประเภทไฟล์ Excel
        ]);

        $filePath = $request->filePath; // แก้ไขเพื่อให้ได้ไฟล์ที่ถูกอัปโหลด
        $month = $request->month;
        $year = $request->year;

        try {
            DB::beginTransaction(); // เริ่มต้น transaction

            // ถ้าเลือก 'new' ให้ลบข้อมูลเก่าที่มีเดือนและปีนี้
            if ($request->file_choice == 'new') {
                Installfttx::where('month', $request->month)->where('year', $request->year)->delete();
                SumInstallfttx::where('month', $request->month)->where('year', $request->year)->delete();
                Totalinstallfttx::where('month', $request->month)->where('year', $request->year)->delete();
                Exportinstllfttx::where('month', $request->month)->where('year', $request->year)->delete();
            }
          

            // ใช้ไฟล์ที่รับจากฟอร์มและนำเข้าข้อมูล
            Excel::import(new installfttxImport($month, $year), $filePath);
            Excel::import(new SumInstallfttxImport($month, $year), $filePath);
            Excel::import(new TotalfttxImport($month, $year), $filePath);
            Excel::import(new exportinstallfttximport($month, $year), $filePath);
         

            DB::commit(); // commit เมื่อทุกอย่างเสร็จสมบูรณ์

            return redirect()->route('importdata')->with('status', 'เพิ่มไฟล์ใหม่แทนที่แล้ว!!!');
        } catch (\Exception $e) {
            // หากเกิดข้อผิดพลาด, rollback การทำงานทั้งหมด
            DB::rollback();

            // ส่งข้อความผิดพลาดกลับไปยังผู้ใช้
            return redirect()->back()->with('error', 'ไฟล์ที่คุณนำเข้ามีข้อมูลไม่สมบูรณ์ ');
        }
    }






    function datacenter()
    {
        // ดึงข้อมูลจากฐานข้อมูล
        $send_data = suminstallfttx::all(); // ใช้ all() เพื่อดึงข้อมูลทั้งหมดจากตาราง

        // ส่งข้อมูลไปยัง view
        return view('report.viewInstallFTTxcenter', compact('send_data'));
    }

    public function datainstallfttx()
    {
        // ดึงข้อมูลจาก model SumInstallfttx ที่มีค่า 'sum_installation_center' เป็น "รวม ภน"
        // และกรองค่าซ้ำ
        $installationCenters = SumInstallfttx::whereIn('sum_installation_center', ['รวม ตป.1','รวม ตป.2'])
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
        $currentYear = SumInstallfttx::max('year');  // ใช้ max() เพื่อดึงปีล่าสุด


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
                return in_array($item->sum_installation_center, ['รวม ตป.1','รวม ตป.2', 'รวม']);
            })
            ->sortByDesc('sum_installation_percentage_within_3_days')
            ->take(5);

        $sortedDataMin = $latestMonthData
            ->reject(function ($item) {
                return in_array($item->sum_installation_center, ['รวม ตป.1','รวม ตป.2', 'รวม']);
            })
            ->sortBy('sum_installation_percentage_within_3_days') // ใช้ sortBy เพื่อเรียงจากน้อยไปมาก
            ->take(1); // เลือก 1 รายการแรก

        // กำหนดแผนที่ระหว่างรหัสกับชื่อจังหวัด
        $content = [
            'รวม บตป.1 (กส.)' => 'กาฬสินธุ์',
            'รวม บตป.1 (ขก.)' => 'ขอนแก่น',
            'รวม บตป.1 (นค.)' => 'หนองคาย',
            'รวม บตป.1 (นพ.)' => 'นครพนม',
            'รวม บตป.1 (นภ.)' => 'หนองบัวลำภู',
            'รวม บตป.1 (บก.)' => 'บึงกาฬ',
            'รวม บตป.1 (มค.)' => 'มหาสารคาม',
            'รวม บตป.1 (มห.)' => 'มุกดาหาร',
            'รวม บตป.1 (รอ.)' => 'ร้อยเอ็ด',
            'รวม บตป.1 (ลย.)' => 'เลย',
            'รวม บตป.1 (สน.)' => 'สกลนคร',
            'รวม บตป.1 (อด.)' => 'อุดรธานี',
            'รวม บตป.2 (ชภ.)' => 'ชัยภูมิ',
            'รวม บตป.2 (นม.)' => 'นครราชสีมา',
            'รวม บตป.2 (บร.)' => 'บุรีรัมย์',
            'รวม บตป.2 (ยส.)' => 'ยโสธร',
            'รวม บตป.2 (ศก.)' => 'ศรีสะเกษ',
            'รวม บตป.2 (สร.)' => 'สุรินทร์',
            'รวม บตป.2 (อจ.)' => 'อำนาจเจริญ',
            'รวม บตป.2 (อบ.)' => 'อุบลราชธานี',
        ];

        // การแปลงข้อมูลจาก sum_installation_center ให้เป็นชื่อจังหวัด
        $labels = $latestMonthData->pluck('sum_installation_center')->map(function ($item) use ($content) {
            return isset($content[$item]) ? $content[$item] : null;  // ถ้าไม่พบก็จะใช้ค่าเดิม
        });

        // ดึงข้อมูลจาก sum_installation_percentage_within_3_days และกรองตามค่าใน labels
        $data1 = $latestMonthData->pluck('sum_installation_percentage_within_3_days')
            ->filter(function ($item, $key) use ($labels) {
                // ตรวจสอบให้แน่ใจว่า $labels ที่ตรงกันไม่ใช่ null และค่าของ sum_installation_percentage_within_3_days ไม่เป็น null
                return !is_null($labels[$key]);
            });
            $latestYear = $latestMonthData->first()->year; // เลือกปีจากข้อมูลล่าสุดใน Collection

     





        // คืนค่าผลลัพธ์ไปยัง view พร้อมกับทั้งสองตัวแปร
        return view('report.viewInstallFTTx', compact('installationCenters', 'sortedDataMax', 'latestMonthData', 'sortedDataMin', 'labels','data1','latestYear'));
    }

    public function datainstallfttxYear(Request $request)
    {
        // รับค่า year จาก query string, ถ้าไม่มีจะใช้ปีปัจจุบัน
        $year = $request->input('year'); // ค่า default เป็นปีปัจจุบัน
        $currentYear = now()->year; // ดึงปีปัจจุบันจากนาฬิกาโลก

        // ถ้าปีที่ส่งมาตรงกับปีปัจจุบัน
        if ($year == $currentYear) {
            // ดึงข้อมูลในปีที่ระบุจาก Installfttx
            $data = Installfttx::where('year', $year) // ดึงข้อมูลในปีที่ระบุ
                ->select('year', 'month')
                ->get();

            // ถ้าไม่มีข้อมูลในปีนั้น
            if ($data->isEmpty()) {
                // ส่งข้อมูลข้อความไปยัง view สำหรับการแสดงใน div
                return view('report.viewInstallFTTx')->with('message', 'ปีนี้ไม่มีข้อมูล');
            }
        }

        // ดึงข้อมูลจาก model SumInstallfttx ที่มีค่า 'sum_installation_center' เป็น "รวม ภน"
        $installationCenters = SumInstallfttx::whereIn('sum_installation_center', ['รวม ตป.1','รวม ตป.2'])
            ->distinct() // กรองค่าซ้ำ
            ->pluck('sum_installation_center');

        // ดึงข้อมูลที่มีปีตรงกับค่า year ที่ได้รับ
        $sumInstallfttx = SumInstallfttx::where('year', $year)->get();

        // ถ้าไม่มีข้อมูลในปีนั้น ให้แจ้งเตือน
        if ($sumInstallfttx->isEmpty()) {
            return redirect()->route('viewInstallFTTx')->with('alert', 'ไม่มีข้อมูลในปีนี้' . $year);
        }

        // แปลงชื่อเดือนเป็นหมายเลขเดือน
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

        // การจัดเรียงและคำนวณข้อมูลที่เหลือ
        $sortedDataMax = $latestMonthData
            ->reject(function ($item) {
                return in_array($item->sum_installation_center, ['รวม ตป.1','รวม ตป.2', 'รวม']);
            })
            ->sortByDesc('sum_installation_percentage_within_3_days')
            ->take(5);

        $sortedDataMin = $latestMonthData
            ->reject(function ($item) {
                return in_array($item->sum_installation_center, ['รวม ตป.1','รวม ตป.2', 'รวม']);
            })
            ->sortBy('sum_installation_percentage_within_3_days') // ใช้ sortBy เพื่อเรียงจากน้อยไปมาก
            ->take(1); // เลือก 1 รายการแรก


       
        // กำหนดแผนที่ระหว่างรหัสกับชื่อจังหวัด
        $content = [
            'รวม บตป.1 (กส.)' => 'กาฬสินธุ์',
            'รวม บตป.1 (ขก.)' => 'ขอนแก่น',
            'รวม บตป.1 (นค.)' => 'หนองคาย',
            'รวม บตป.1 (นพ.)' => 'นครพนม',
            'รวม บตป.1 (นภ.)' => 'หนองบัวลำภู',
            'รวม บตป.1 (บก.)' => 'บึงกาฬ',
            'รวม บตป.1 (มค.)' => 'มหาสารคาม',
            'รวม บตป.1 (มห.)' => 'มุกดาหาร',
            'รวม บตป.1 (รอ.)' => 'ร้อยเอ็ด',
            'รวม บตป.1 (ลย.)' => 'เลย',
            'รวม บตป.1 (สน.)' => 'สกลนคร',
            'รวม บตป.1 (อด.)' => 'อุดรธานี',
            'รวม บตป.2 (ชภ.)' => 'ชัยภูมิ',
            'รวม บตป.2 (นม.)' => 'นครราชสีมา',
            'รวม บตป.2 (บร.)' => 'บุรีรัมย์',
            'รวม บตป.2 (ยส.)' => 'ยโสธร',
            'รวม บตป.2 (ศก.)' => 'ศรีสะเกษ',
            'รวม บตป.2 (สร.)' => 'สุรินทร์',
            'รวม บตป.2 (อจ.)' => 'อำนาจเจริญ',
            'รวม บตป.2 (อบ.)' => 'อุบลราชธานี',
        ];
        // การแปลงข้อมูลจาก sum_installation_center ให้เป็นชื่อจังหวัด
        $labels = $latestMonthData->pluck('sum_installation_center')->map(function ($item) use ($content) {
            return isset($content[$item]) ? $content[$item] : null;  // ถ้าไม่พบก็จะใช้ค่าเดิม
        });

        // ดึงข้อมูลจาก sum_installation_percentage_within_3_days และกรองตามค่าใน labels
        $data1 = $latestMonthData->pluck('sum_installation_percentage_within_3_days')
            ->filter(function ($item, $key) use ($labels) {
                // ตรวจสอบให้แน่ใจว่า $labels ที่ตรงกันไม่ใช่ null และค่าของ sum_installation_percentage_within_3_days ไม่เป็น null
                return !is_null($labels[$key]);
            });


        // คืนค่าผลลัพธ์ไปยัง view พร้อมกับทั้งสองตัวแปร
        return view('report.viewInstallFTTx', compact('installationCenters', 'labels', 'data1', 'sortedDataMax', 'latestMonthData', 'sortedDataMin'));
    }








    public function dataprovin()
    {
        $data = Installfttx::all(); // ใช้ all() เพื่อดึงข้อมูลทั้งหมดจากตาราง
        return view('report.viewInstallFTTxprovin', compact('data'));
    }

    public function sortprovin($section, $year, $month)
    {

        // กำจัดคำว่า "รวม " ออก
        $section = str_replace('รวม ', '', $section);

        // ใช้ LIKE แบบละเอียด
        $sumData = SumInstallfttx::where('sum_installation_center', 'LIKE', "%$section%")
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->get();


        // กำหนดแผนที่ระหว่างรหัสกับชื่อจังหวัด
        $content = [
            'รวม บตป.1 (กส.)' => 'กาฬสินธุ์',
            'รวม บตป.1 (ขก.)' => 'ขอนแก่น',
            'รวม บตป.1 (นค.)' => 'หนองคาย',
            'รวม บตป.1 (นพ.)' => 'นครพนม',
            'รวม บตป.1 (นภ.)' => 'หนองบัวลำภู',
            'รวม บตป.1 (บก.)' => 'บึงกาฬ',
            'รวม บตป.1 (มค.)' => 'มหาสารคาม',
            'รวม บตป.1 (มห.)' => 'มุกดาหาร',
            'รวม บตป.1 (รอ.)' => 'ร้อยเอ็ด',
            'รวม บตป.1 (ลย.)' => 'เลย',
            'รวม บตป.1 (สน.)' => 'สกลนคร',
            'รวม บตป.1 (อด.)' => 'อุดรธานี',
            'รวม บตป.2 (ชภ.)' => 'ชัยภูมิ',
            'รวม บตป.2 (นม.)' => 'นครราชสีมา',
            'รวม บตป.2 (บร.)' => 'บุรีรัมย์',
            'รวม บตป.2 (ยส.)' => 'ยโสธร',
            'รวม บตป.2 (ศก.)' => 'ศรีสะเกษ',
            'รวม บตป.2 (สร.)' => 'สุรินทร์',
            'รวม บตป.2 (อจ.)' => 'อำนาจเจริญ',
            'รวม บตป.2 (อบ.)' => 'อุบลราชธานี',
        ];

        // การแปลงข้อมูลจาก sum_installation_center ให้เป็นชื่อจังหวัด
        $labels = $sumData->pluck('sum_installation_center')->map(function ($item) use ($content) {
            return isset($content[$item]) ? $content[$item] : null;  // ถ้าไม่พบก็จะใช้ค่าเดิม
        });

        $data = $sumData->pluck('sum_installation_percentage_within_3_days'); // ใช้เปอร์เซ็นต์รวม

        return view('report.viewInstallFTTxprovin', compact('sumData', 'labels', 'data', 'section', 'year', 'month'));
    }
    public function sortprovinMonth($section, $year)
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

        return view('report.viewInstallFTTxprovinSort', compact('sumData', 'labels', 'data', 'section', 'year'));
    }

    public function sortcenter($section, $year, $month)
    {
        // กำจัดคำว่า "รวม " ออก
        $section = str_replace('รวม ', '', $section);

        $installData = Installfttx::where('section', 'LIKE', "%$section%")
            ->where('year', '=', $year)
            ->where('month', '=', $month)
            ->get();




        // ดึงข้อมูลสำหรับ labels และ data
        $labels = $installData->pluck('installation_center'); // ใช้ชื่อของ section หรือ center เป็น label
        $data = $installData->pluck('installation_percentage_within_3_days'); // ใช้เปอร์เซ็นต์การติดตั้ง
        
      
    
        // ส่งข้อมูลไปยัง view
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

    public function exportview(Request $request)
    {
        // รับค่าปีและเดือนจาก URL
        $year = $request->input('year');
        $month = $request->input('month');
        // ดึงข้อมูลจากฐานข้อมูลที่ตรงกับปีและเดือน
        $data = Exportinstllfttx::where('year', $year)
            ->where('month', $month)
            ->get();
        if ($data) {
            return $this->export($year, $month);
        }
    }

    // ฟังก์ชันสำหรับการส่งออกเป็น Excel
    public function export($year, $month)
    {
        // ส่งออกข้อมูลเป็นไฟล์ Excel
        return Excel::download(new ExportFttxReport($year, $month), 'report_' . $year . '_' . $month . '.xlsx');
    }


    public function getExistingMonths2(Request $request)
    {
        // รับค่าปีจากคำขอ
        $year = $request->input('year');


        // ดึงข้อมูลปีและเดือนที่ตรงกับปีที่ระบุ
        $data = Installfttx::where('year', $year)
            ->select('year', 'month')
            ->distinct() // ดึงเฉพาะค่าที่ไม่ซ้ำ
            ->get();


        // ส่งข้อมูลเป็น JSON response
        return response()->json($data);
    }


    public function exportview2(Request $request)
    {
        // รับค่าปี, เดือน และ section จาก URL
        $year = $request->input('year');
        $month = $request->input('month');
        $section = $request->input('section');




        // ตรวจสอบว่าได้รับค่าทั้งหมดครบถ้วน
        if (!$year || !$month || !$section) {
            return response()->json(['error' => 'Year, Month, and Section are required.'], 400);
        }
        if ($section == '2' || $section == '3') {
            // ใช้ LIKE แบบละเอียด
            $data = Installfttx::where('region', 'LIKE', "%$section%")
                ->where('year', '=', $year)
                ->where('month', '=', $month)
                ->get();
        } else {
            // ถ้าไม่มีตัวเลข 2 หรือ 3, ใช้ section ตามปกติ
            $data = Installfttx::where('section', 'LIKE', "%$section%")
                ->where('year', '=', $year)
                ->where('month', '=', $month)
                ->get();
        }


        // ถ้ามีข้อมูล ให้เรียกฟังก์ชัน export2
        if ($data->isNotEmpty()) {
            return $this->export2($year, $month, $section);
        }


        // ถ้าไม่มีข้อมูล แสดงข้อความ error
        return response()->json(['error' => 'No data found for the specified year, month, and section.'], 404);
    }


    // ฟังก์ชันสำหรับการส่งออกเป็น Excel
    public function export2($year, $month, $section)
    {
        // ใช้ exportCenter เพื่อสร้างรายงานและดาวน์โหลดไฟล์ Excel
        return Excel::download(
            new exportCenter($year, $month, $section),
            'report_' . $year . '_' . $month . '_' . $section . '.xlsx'
        );
    }

    public function exportData()
    {
        return view('report.view_export');
    }

    public function delete_data($year, $month)
    {
        try {
            // ลบข้อมูลที่ตรงกับปีและเดือน
            Installfttx::where('year', $year)
                ->where('month', $month)
                ->delete();
            SumInstallfttx::where('year', $year)
                ->where('month', $month)
                ->delete();
            Totalinstallfttx::where('year', $year)
                ->where('month', $month)
                ->delete();
            Exportinstllfttx::where('year', $year)
                ->where('month', $month)
                ->delete();

            return response()->json(['message' => 'Data deleted successfully!']);
        } catch (\Exception $e) {
            // ถ้ามีข้อผิดพลาด
            return response()->json(['error' => 'Something went wrong.'], 500);
        }
    }
}
