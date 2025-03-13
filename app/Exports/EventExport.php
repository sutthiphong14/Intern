<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\ProvinceActivity;
use App\Models\TypeActivity;
use App\Models\Fttxbroadband;
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
            'types'
        ));
    }
}
