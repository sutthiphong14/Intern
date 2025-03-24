<?php

namespace App\Exports;

use App\Models\Customer;
use App\Models\Fttxbroadband;
use App\Models\Simmy;
use App\Models\IctSolution;
use App\Models\TopUp;
use App\Models\ProvinceActivity;
use App\Models\ServiceCenterActivity;
use App\Models\ServeActivity;
use App\Models\TypeActivity;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CustomerExport implements FromView
{
    protected $province_id;
    protected $type_id;

    public function __construct($province_id, $type_id)
    {
        $this->province_id = $province_id;
        $this->type_id = $type_id;
    }

    public function view(): View
    {
        $data = Customer::with(['service', 'center', 'province', 'type', 'promotion', 'speed', 'price'])
            ->where('type_id', $this->type_id)
            ->where('province_id', $this->province_id)
            ->get();

        $customers = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])
            ->where('type_id', $this->type_id)
            ->orderBy('service_id')
            ->orderBy('cus_fullname')
            ->get()
            ->groupBy('service.service_name');

        $fttxData = Fttxbroadband::whereIn('cus_id', $customers->pluck('cus_id'))->get()->keyBy('cus_id');
        $simmyData = Simmy::whereIn('cus_id', $customers->pluck('cus_id'))->get()->keyBy('cus_id');
        $ictData = IctSolution::with('products')->whereIn('cus_id', $customers->pluck('cus_id'))->get()->keyBy('cus_id');

        $provinces = ProvinceActivity::all();
        $centers = ServiceCenterActivity::all();
        $serviceTypes = ServeActivity::where('type_id', $this->type_id)->get();
        $types = TypeActivity::where('type_id', $this->type_id)->get();

        $provinceName = $this->province_id ? ProvinceActivity::find($this->province_id)->province_name ?? null : null;
        $activityName = $types->first()->type_name ?? "ไม่ระบุ";

        $TopUp = TopUp::with(['province', 'center'])
            ->where('type_id', $this->type_id)
            ->where('province_id', $this->province_id)
            ->get();

        return view('events.export_customer', compact(
            'customers',
            'fttxData',
            'simmyData',
            'ictData',
            'provinces',
            'centers',
            'serviceTypes',
            'types',
            'provinceName',
            'activityName',
            'data',
            'TopUp'
        ));
    }
}
