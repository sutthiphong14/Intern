<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\ProvinceActivity;
use App\Models\TypeActivity;
use App\Models\Fttxbroadband;
use App\Models\IctService;
use App\Models\Simmy;
use App\Models\TopUp;
use App\Models\IctSolution;
use App\Models\ServeActivity;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EventExport implements FromView
{
    protected $type_id;

    public function __construct($type_id)
    {
        $this->type_id = $type_id;
    }


    public function view(): View
    {
        // กรองข้อมูล Customer ตาม type_service
        $dataQuery = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center']);
        if ($this->type_id !== null) {
            $dataQuery->whereHas('service', fn($query) => $query->where('service_name', $this->type_id));
        }
        $data = $dataQuery->get();

        // ดึงข้อมูล Province และ TypeActivity
        $provinces = ProvinceActivity::all();
        $types = TypeActivity::where('type_id', $this->type_id)->first();

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $fttxData = Fttxbroadband::where('type_id', $this->type_id)
            ->select('province_id', 'new', 'installation_type')->whereIn('new', [1, 2]) // ✅ ใช้ whereIn() แทน
            ->get()
            ->groupBy('province_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $adjustData = Fttxbroadband::where('type_id', $this->type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 0)
            ->get()
            ->groupBy('province_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $moveData = Fttxbroadband::where('type_id', $this->type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 2)
            ->get()
            ->groupBy('province_id');


        $fttxNew = $fttxData->map(fn($items) => $items->whereIn('new', [1, 2])->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());
        $adjust = $adjustData->map(fn($items) => $items->where('new', 0)->count());
        $move = $moveData->map(fn($items) => $items->where('new', 2)->count());


        // โหลดข้อมูล Simmy
        $simmyData = Simmy::where('type_id', $this->type_id)
            ->select('province_id', 'cus_new')
            ->get()
            ->groupBy('province_id');

        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        // โหลดข้อมูล TopUp
        $topUpData = TopUp::where('type_id', $this->type_id)
            ->select('province_id', 'amount')
            ->get()
            ->groupBy('province_id');

        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        // โหลดข้อมูล IctSolution ของทุกจังหวัด
        $ictData1 = IctSolution::where('type_id', $this->type_id)
            ->with('products') // โหลด pivot data
            ->get();

        // กำหนดรายการบริการหลัก
        $mainServices = ['CCTV', 'smart pole', 'internet wifi', 'smart office', 'cyber security', 'ultimate connect'];
        $serviceNames = array_merge($mainServices, ['บริการอื่นๆ']);

        // ดึงรายชื่อจังหวัดทั้งหมดจากฐานข้อมูล
        $allProvinces = ProvinceActivity::pluck('province_id')->toArray();

        // คำนวณสรุปข้อมูลและแยกตามบริการ
        $ictSummary = $ictData1->map(function ($ict) use ($mainServices) {
            return $ict->products->map(function ($product) use ($ict, $mainServices) {
                // หา IctService ที่เชื่อมกับ IctSolution
                $service = IctService::find($ict->ict_service_id);
                $originalServiceName = $service ? $service->service_name : '';

                // ตรวจสอบว่าชื่อบริการอยู่ในรายการบริการหลักหรือไม่
                $serviceName = in_array($originalServiceName, $mainServices)
                    ? $originalServiceName
                    : 'บริการอื่นๆ';

                return [
                    'province_id' => $ict->province_id,
                    'ict_id' => $ict->ict_id,
                    'service_name' => $serviceName, // เก็บชื่อบริการที่จัดกลุ่มแล้ว
                    'quantity' => $product->pivot->quantity ?? 0,
                    'total_price' => ($product->pivot->quantity ?? 0) * ($product->pivot->price ?? 0),
                ];
            });
        })->flatten(1);

        // สร้าง array โครงสร้างเริ่มต้นสำหรับทุกจังหวัดและทุกบริการ
        $provinceSummary = [];
        foreach ($allProvinces as $provinceId) {
            $provinceSummary[$provinceId] = [];

            // สร้างข้อมูลเริ่มต้นสำหรับทุกบริการใน province นี้
            foreach ($serviceNames as $serviceName) {
                $provinceSummary[$provinceId][$serviceName] = [
                    'total_quantity' => 0,
                    'total_price' => 0,
                ];
            }
        }

        // เติมข้อมูลจริงลงไป
        foreach ($ictSummary as $summary) {
            $provinceId = $summary['province_id'];
            $serviceName = $summary['service_name'];

            // เพิ่มค่าเข้าไปในโครงสร้างที่มีอยู่แล้ว
            $provinceSummary[$provinceId][$serviceName]['total_quantity'] += $summary['quantity'];
            $provinceSummary[$provinceId][$serviceName]['total_price'] += $summary['total_price'];
        }

        // โหลดข้อมูล IctSolution
        $ictData = IctSolution::where('type_id', $this->type_id)
            ->select('province_id', 'income')
            ->get()
            ->groupBy('province_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        // ดึงข้อมูลประเภทบริการ
        $serviceTypes = ServeActivity::all();

        return view('events.activity_list', compact(
            'serviceTypes',
            'data',
            'provinces',
            'fttxNew',
            'selfInstall',
            'HireInstall',
            'adjust',
            'move',
            'Simmy_new',
            'Simmy_move',
            'Simmy_count',
            'Simmy_price',
            'Ict_count',
            'Ict_income',
            'types',
            'ictData1',
            'ictSummary',
            'provinceSummary',
            'serviceNames'
        ));
    }
}
