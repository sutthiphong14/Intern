<?php

namespace App\Http\Controllers;

use App\Exports\EventExport;
use App\Models\Customer;
use App\Models\Fttxbroadband;
use App\Models\IctProduct;
use App\Models\IctService;
use App\Models\IctSolution;
use App\Models\Simmy;
use App\Models\TopUp;
use App\Models\PriceActivity;
use App\Models\ProvinceActivity;
use App\Models\PromotionActivity;
use App\Models\ServeActivity;
use App\Models\ServiceCenterActivity;
use App\Models\SpeedActivity;
use App\Models\TypeActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class ActivityController extends Controller
{
    //กิจกรรม
    public function ListType()
    {



        $provinces = ProvinceActivity::all();

        // ดึงข้อมูลประเภทบริการ (type_id)
        $typeActivities = Typeactivity::all();

        // จัดกลุ่มข้อมูลตาม type_id
        $dataByType = [];

        // ดึงข้อมูล Fttxbroadband ที่ new = 1
        $fttxNew = Fttxbroadband::where('new', 1)
            ->get()
            ->groupBy('type_id') // จัดกลุ่มตาม type_id
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('new'); // นับค่าที่ซ้ำกันในแต่ละ province_id
                });
            });

        $adjust = Fttxbroadband::where('new', 0)
            ->get()
            ->groupBy('type_id') // จัดกลุ่มตาม type_id
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('new'); // นับค่าที่ซ้ำกันในแต่ละ province_id
                });
            });

        $fttxmove = Fttxbroadband::where('new', 2)
            ->get()
            ->groupBy('type_id') // จัดกลุ่มตาม type_id
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('new'); // นับค่าที่ซ้ำกันในแต่ละ province_id
                });
            });


        // ดึงข้อมูล Fttxbroadband ที่ติดตั้งเอง
        $selfInstall = Fttxbroadband::where('installation_type', 1)->whereIn('new', [1, 2]) // ✅ ใช้ whereIn() แทน
            ->get()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('installation_type');
                });
            });

        // ดึงข้อมูล Fttxbroadband ที่จ้างผู้รับเหมา
        $HireInstall = Fttxbroadband::where('installation_type', 0)->whereIn('new', [1, 2])
            ->get()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('installation_type');
                });
            });

        // ดึงข้อมูล Simmy
        $Simmy_new = Simmy::where('cus_new', 1)
            ->get()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('cus_new');
                });
            });

        $Simmy_move = Simmy::where('cus_new', 0)
            ->get()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('cus_new');
                });
            });

        $Simmy_count = TopUp::all()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count();
                });
            });

        $Simmy_price = TopUp::all()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->sum('amount');
                });
            });

        // ดึงข้อมูล IctSolution
        $Ict_count = IctSolution::all()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count(); // นับจำนวนในแต่ละ province_id
                });
            });

        $Ict_income = IctSolution::all()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->sum('income'); // รวมรายได้ในแต่ละ province_id
                });
            });

        // คำนวณค่ารวมใน Controller
        $sumByType = [];

        foreach ($typeActivities as $type) {
            $sumByType[$type->type_id] = [
                'fttxNew' => 0,
                'selfInstall' => 0,
                'hireInstall' => 0,
                'adjust' => 0,
                'fttxmove' => 0,
                'new' => 0,
                'move' => 0,
                'count' => 0,
                'price' => 0,
                'ictCount' => 0,
                'ictIncome' => 0,
            ];

            // คำนวณค่ารวมในแต่ละ type_id
            foreach ($provinces as $province) {
                if (isset($fttxNew[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['fttxNew'] += $fttxNew[$type->type_id][$province->province_id];
                }
                if (isset($selfInstall[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['selfInstall'] += $selfInstall[$type->type_id][$province->province_id];
                }
                if (isset($HireInstall[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['hireInstall'] += $HireInstall[$type->type_id][$province->province_id];
                }
                if (isset($adjust[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['adjust'] += $adjust[$type->type_id][$province->province_id];
                }
                if (isset($fttxmove[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['fttxmove'] += $fttxmove[$type->type_id][$province->province_id];
                }
                if (isset($Simmy_new[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['new'] += $Simmy_new[$type->type_id][$province->province_id];
                }
                if (isset($Simmy_move[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['move'] += $Simmy_move[$type->type_id][$province->province_id];
                }
                if (isset($Simmy_count[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['count'] += $Simmy_count[$type->type_id][$province->province_id];
                }
                if (isset($Simmy_price[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['price'] += $Simmy_price[$type->type_id][$province->province_id];
                }
                if (isset($Ict_count[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['ictCount'] += $Ict_count[$type->type_id][$province->province_id];
                }
                if (isset($Ict_income[$type->type_id][$province->province_id])) {
                    $sumByType[$type->type_id]['ictIncome'] += $Ict_income[$type->type_id][$province->province_id];
                }
            }
        }
        $data = $typeActivities->count();
        $typeIds = collect($typeActivities)->pluck('type_id')->toArray();  // ดึงแค่ type_id

        $maxTypeId = !empty($typeIds) ? max($typeIds) : null;  // ตรวจสอบก่อนใช้ max()





        $typeNames = [];
        $fttxNewData = $selfInstallData = $hireInstallData = $adjustData = $moveData = [];


        foreach ($sumByType as $typeId => $data) {
            // ตรวจสอบว่า type_id มีใน $typeActivities หรือไม่
            $typeName = collect($typeActivities)->firstWhere('type_id', $typeId)->type_name ?? 'ไม่ระบุ';

            $typeNames[] = $typeName;
            $selfInstall = $data['selfInstall'] ?? 0;
            $hireInstall = $data['hireInstall'] ?? 0;
            $adjust = $data['adjust'] ?? 0;
            $fttxmove = $data['fttxmove'] ?? 0;

            $fttxNewData[] = $selfInstall + $hireInstall;
            $selfInstallData[] = $selfInstall;
            $hireInstallData[] = $hireInstall;
            $adjustData[] = $adjust;
            $moveData[] = $fttxmove;
        }







        return view('events.TypeActivityList', compact('data', 'typeActivities', 'sumByType', 'maxTypeId', 'typeNames', 'fttxNewData', 'selfInstallData', 'hireInstallData', 'adjustData', 'moveData'));
    }

    public function TypeInsert(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        try {
            // บันทึกข้อมูลลงใน type_activity
            $newRecord = Typeactivity::create([
                'type_name' => $request->type_name
            ]);

            // บันทึกข้อมูลลงใน serve_activity โดยใช้ id ของ type_activity
            ServeActivity::create([
                'service_name' => 'Fttx Broadband',
                'type_id' => $newRecord->id  // ใช้ $newRecord->id ไม่ใช่ $newRecord->type_id
            ]);

            ServeActivity::create([
                'service_name' => 'SIM my(เติมเงิน)',
                'type_id' => $newRecord->id  // ใช้ $newRecord->id ไม่ใช่ $newRecord->type_id
            ]);

            ServeActivity::create([
                'service_name' => 'SIM my(รายเดือน)',
                'type_id' => $newRecord->id  // ใช้ $newRecord->id ไม่ใช่ $newRecord->type_id
            ]);

            ServeActivity::create([
                'service_name' => 'ICT solution',
                'type_id' => $newRecord->id  // ใช้ $newRecord->id ไม่ใช่ $newRecord->type_id
            ]);

            // ส่งข้อมูลสำเร็จกลับไป
            return response()->json([
                'success' => true,
                'message' => 'เพิ่มกิจกรรมสำเร็จ',
                'id' => $newRecord->id
            ]);
        } catch (\Exception $e) {
            // กรณีเกิดข้อผิดพลาด
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }




    public function TypeDelete($type_id)
    {
        $data = Typeactivity::where('type_id', $type_id);

        $data->delete();
        return redirect()->route('type_list')->with('success', 'ลบกิจกรรมสำเร็จ');
    }

    public function Typeupdate(Request $request, $type_id)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        $type_name = $request->input('type_name');  // ดึงค่าจากฟอร์ม

        // หาแถวที่ตรงกับ service_id
        $data = Typeactivity::where('type_id', $type_id)->first();


        if ($data) {
            Typeactivity::where('type_id', $type_id)->update(['type_name' => $type_name]);
        } else {
            return redirect()->route('type_list')
                ->with('error', 'Type not found');
        }

        return redirect()->route('type_list')
            ->with('success', 'อัพเดทกิจกรรมสำเร็จ!');
    }



    //บริการ
    public function ListService($type_id)
    {

        $data = ServeActivity::where('type_id', $type_id)->get();
        $typeName = TypeActivity::where('type_id', $type_id)->pluck('type_name')->first();




        return view("events.ServeActivityList", compact('data', 'typeName', 'type_id'));
    }

    public function ServiceInsert(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',

        ]);

        ServeActivity::create($request->all());
        $data = ServeActivity::all();
        return redirect()->route('service_list', compact('data'))
            ->with('success', 'เพิ่มบริการสำเร็จ');
    }

    public function ServiceDelete($service_id)
    {
        $data = ServeActivity::where('service_id', $service_id);

        $data->delete();
        return redirect()->route('service_list')->with('success', 'ลบบริการสำเร็จ');
    }

    public function Serviceupdate(Request $request, $service_id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
        ]);

        $service_name = $request->input('service_name');  // ดึงค่าจากฟอร์ม

        // หาแถวที่ตรงกับ service_id
        $data = ServeActivity::where('service_id', $service_id)->first();


        if ($data) {
            ServeActivity::where('service_id', $service_id)->update(['service_name' => $service_name]);
        } else {
            return redirect()->route('service_list')
                ->with('error', 'Service not found');
        }

        return redirect()->back()->with('success', 'อัพเดทบริการสำเร็จ!');
    }


    //โปรโมชั่น

    public function ListPromotion($service_id)
    {
        $data = PromotionActivity::where('service_id', $service_id)->get();
        $typeId = ServeActivity::where('service_id', $service_id)->pluck('type_id')->first();


        return view('events.promotionActivityList', compact('data', 'service_id', 'typeId'));
    }


    public function PromotionInsert(Request $request, $service_id)
    {
        $request->validate([
            'promotion_name' => 'required|string|max:255',

        ]);

        PromotionActivity::create([
            'promotion_name' => $request->promotion_name,
            'service_id' => $service_id  // ค่าที่ต้องการใส่จาก parameter
        ]);
        $data = PromotionActivity::all();
        return redirect()->route('promotion_list', compact('data', 'service_id'))
            ->with('success', 'เพิ่มโปรโมชั่นสำเร็จ');
    }

    public function PromotionDelete($service_id, $promotion_id)
    {
        PromotionActivity::where('promotion_id', $promotion_id)
            ->where('service_id', $service_id)
            ->delete();
        $data = PromotionActivity::all();
        return redirect()->route('promotion_list', compact('data', 'service_id'))
            ->with('success', 'ลบโปรโมชั่นสำเร็จ');
    }

    public function PromotionUpdate(Request $request, $service_id, $promotion_id)
    {
        $request->validate([
            'promotion_name' => 'required|string|max:255',

        ]);

        PromotionActivity::where('promotion_id', $promotion_id)
            ->where('service_id', $service_id)->update([
                'promotion_name' => $request->promotion_name,
            ]);
        $data = PromotionActivity::all();
        return redirect()->route('promotion_list', compact('data', 'service_id'))
            ->with('success', 'อัปเดตโปรโมชั่นสำเร็จ');
    }

    //ความเร็ว
    public function ListSpeed($service_id, $promotion_id)
    {

        $data = SpeedActivity::where('promotion_id', $promotion_id)
            ->where('service_id', $service_id)
            ->get();
        return view('events.speedActivityList', compact('data', 'service_id', 'promotion_id'));
    }

    public function SpeedInsert(Request $request, $service_id, $promotion_id)
    {
        $request->validate([
            'speed_name' => 'required|string|max:255',

        ]);


        SpeedActivity::create([
            'speed_name' => $request->speed_name,
            'service_id' => $service_id,
            'promotion_id' => $promotion_id // ค่าที่ต้องการใส่จาก parameter
        ]);
        $data = SpeedActivity::all();
        return redirect()->route('speed_list', compact('data', 'service_id', 'promotion_id'))
            ->with('success', 'เพิ่มความเร็วสำเร็จ');
    }

    public function SpeedDelete($service_id, $promotion_id, $speed_id)
    {
        SpeedActivity::where('promotion_id', $promotion_id)
            ->where('speed_id', $speed_id)
            ->delete();
        $data = SpeedActivity::all();
        return redirect()->route('speed_list', compact('data', 'promotion_id', 'service_id'))
            ->with('success', 'ลบความเร็วสำเร็จ');
    }

    public function SpeedUpdate(Request $request, $service_id, $promotion_id, $speed_id)
    {

        $request->validate([
            'speed_name' => 'required|string|max:255',

        ]);

        SpeedActivity::where('speed_id', $speed_id)->update([
            'speed_name' => $request->speed_name,
        ]);
        $data = SpeedActivity::all();
        return redirect()->route('speed_list', compact('service_id', 'promotion_id'))
            ->with('success', 'อัปเดตความเร็วสำเร็จ');
    }

    //ราคา
    public function ListPrice($service_id, $promotion_id, $speed_id)
    {
        $data = PriceActivity::where('speed_id', $speed_id)->get();
        return view('events.priceActivityList', compact('data', 'service_id', 'promotion_id', 'speed_id'));
    }

    public function PriceInsert(Request $request, $service_id, $promotion_id, $speed_id)
    {
        $request->validate([
            'price_name' => 'required|string|max:255',

        ]);
        PriceActivity::create([
            'price_name' => $request->price_name,
            'service_id' => $service_id,
            'promotion_id' => $promotion_id,
            'speed_id' => $speed_id
        ]);
        $data = PriceActivity::all();
        return redirect()->route('price_list', compact('data', 'service_id', 'promotion_id', 'speed_id'))
            ->with('success', 'เพิ่มราคาสำเร็จ');
    }

    public function PriceDelete($service_id, $promotion_id, $speed_id, $price_id)
    {
        PriceActivity::where('speed_id', $speed_id)
            ->where('price_id', $price_id)
            ->delete();
        $data = SpeedActivity::all();
        return redirect()->route('price_list', compact('data', 'service_id', 'promotion_id', 'speed_id'))
            ->with('success', 'ลบราคาสำเร็จ');
    }

    public function PriceUpdate(Request $request, $service_id, $promotion_id, $speed_id, $price_id)
    {
        $request->validate([
            'price_name' => 'required|string|max:255',

        ]);

        PriceActivity::where('price_id', $price_id)->update([
            'price_name' => $request->price_name,
        ]);
        $data = PriceActivity::all();
        return redirect()->route('price_list', compact('data', 'service_id', 'promotion_id', 'speed_id'))
            ->with('success', 'อัปเดตราคาสำเร็จ');
    }

    //บริการ ict 
    public function ListServiceICT($type_id, $service_id)
    {
        $data = IctService::where('type_id', $type_id)->get();
        return view('events.ict_service_list', compact('data', 'type_id', 'service_id'));
    }

    public function ICTServiceInsert(Request $request, $type_id, $service_id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',

        ]);

        IctService::create([
            'service_name' => $request->service_name,
            'description' => $request->description,
            'service_id' => $service_id,
            'type_id' => $type_id


        ]);
        $data = IctService::all();
        return redirect()->back()
            ->with('success', 'เพิ่มบริการสำเร็จ')
            ->with('data', $data);
    }



    public function ICTServiceDelete($ict_service_id, $type_id, $service_id)
    {
        // ลบบริการตาม ict_service_id
        IctService::where('ict_service_id', $ict_service_id)->delete();

        // ดึงข้อมูลทั้งหมดของบริการ
        $data = IctService::all();

        // ส่งพารามิเตอร์ type_id, service_id และ data ไปยัง view
        return redirect()->route('ict_service_list', [$type_id, $service_id])
            ->with('success', 'ลบบริการสำเร็จ')
            ->with('data', $data);
    }

    public function ICTServiceupdate(Request $request, $ict_service_id, $type_id, $service_id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',

        ]);

        IctService::where('ict_service_id', $ict_service_id)->update([
            'service_name' => $request->service_name,
            'description' => $request->description
        ]);
        $data = IctService::all();
        return redirect()->route('ict_service_list', [$type_id, $service_id])
            ->with('success', 'อัปเดตบริการสำเร็จ')
            ->with('data', $data);
    }

    //โปรดัก

    public function ListProduct($type_id, $ict_service_id)
    {
        $data = IctProduct::where('ict_service_id', $ict_service_id)->get();
        return view('events.product_list', compact('data', 'type_id', 'ict_service_id'));
    }


    public function ProductInsert(Request $request, $type_id, $ict_service_id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',

        ]);

        IctProduct::create([
            'product_name' => $request->product_name,
            'description' => $request->description,
            'type_id' => $type_id,
            'ict_service_id' => $ict_service_id
        ]);
        $data = IctProduct::all();
        return redirect()->back()
            ->with('success', 'เพิ่ม product สำเร็จ')
            ->with('data', $data);
    }

    public function ProductDelete($product_id, $type_id, $ict_service_id)
    {
        IctProduct::where('product_id', $product_id)->delete();
        $data = IctProduct::all();
        return redirect()->route('product_list', [$type_id, $ict_service_id])
            ->with('success', 'ลบ product สำเร็จ')
            ->with('data', $data);
    }

    public function ProductUpdate(Request $request, $product_id, $type_id, $ict_service_id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',

        ]);

        IctProduct::where('product_id', $product_id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description
        ]);
        $data = IctProduct::all();
        return redirect()->route('product_list', [$type_id, $ict_service_id])
            ->with('success', 'อัพเดท product สำเร็จ')
            ->with('data', $data);
    }

    //fttx_broadband
    public function FttxList()
    {
        // ดึงข้อมูล Customer และจัดกลุ่มตาม province_id
        $data = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])->get();
        $provinces = ProvinceActivity::all();

        // ดึงข้อมูล Fttxbroadband ที่ new = 1
        $fttxNew = Fttxbroadband::where('new', 1)
            ->get()
            ->groupBy('province_id') // แยกกลุ่มตาม `province_id`
            ->map(function ($items) {
                return $items->count('new'); // รวมค่าที่ซ้ำกันได้
            });


        // ดึงข้อมูล Fttxbroadband ที่ติดตั้งเอง
        $selfInstall = Fttxbroadband::where('installation_type', 1)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('installation_type'); // รวมค่าที่ซ้ำกันได้
            });

        // ดึงข้อมูล Fttxbroadband ที่จ้างผู้รับเหมา
        $HireInstall = Fttxbroadband::where('installation_type', 0)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('installation_type'); // รวมค่าที่ซ้ำกันได้
            });
        return view('events.fttx_broadband', compact('data', 'provinces', 'fttxNew', 'selfInstall', 'HireInstall'));
    }

    //fttx_broadband
    public function Sim_my()
    {
        // ดึงข้อมูล Customer และจัดกลุ่มตาม province_id
        $data = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])->get();
        $provinces = ProvinceActivity::all();
        $Simmy_new = Simmy::where('cus_new', 1)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('cus_new'); // รวมค่าที่ซ้ำกันได้
            });

        $Simmy_move = Simmy::where('cus_new', 0)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('cus_new'); // รวมค่าที่ซ้ำกันได้
            });

        $Simmy_count = TopUp::all()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count(); // นับจำนวนรายการในแต่ละกลุ่ม
            });

        $Simmy_price = TopUp::all()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->sum('amount'); // รวมค่าของ amount ในแต่ละกลุ่ม
            });
        return view('events.sim_my', compact('data', 'provinces', 'Simmy_new', 'Simmy_move', 'Simmy_count', 'Simmy_price'));
    }

    public function activity_list($type_id)
    {
        // กรองข้อมูล Customer ตาม type_service
        $dataQuery = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center']);
        if ($type_id !== null) {
            $dataQuery->whereHas('service', fn($query) => $query->where('service_name', $type_id));
        }
        $data = $dataQuery->get();

        // ดึงข้อมูล Province และ TypeActivity
        $provinces = ProvinceActivity::all();
        $types = TypeActivity::where('type_id', $type_id)->first();

        // โหลดข้อมูล Fttxbroadband ครั้งเดียว
        $fttxData = Fttxbroadband::where('type_id', $type_id)->select('province_id', 'new', 'installation_type')->get()->groupBy('province_id');
        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $adjustData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 0)
            ->get()
            ->groupBy('province_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $moveData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 2)
            ->get()
            ->groupBy('province_id');



        $fttxNew = $fttxData->map(fn($items) => $items->whereIn('new', [1, 2])->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());
        $adjust = $adjustData->map(fn($items) => $items->where('new', 0)->count());
        $move = $moveData->map(fn($items) => $items->where('new', 2)->count());

        // โหลดข้อมูล Simmy และ TopUp ครั้งเดียว
        $simmyData = Simmy::where('type_id', $type_id)->select('province_id', 'cus_new')->get()->groupBy('province_id');
        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        $topUpData = TopUp::where('type_id', $type_id)->select('province_id', 'amount')->get()->groupBy('province_id');
        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        // โหลดข้อมูล IctSolution ของทุกจังหวัด
        $ictData1 = IctSolution::where('type_id', $type_id)
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


        // โหลดข้อมูล IctSolution ครั้งเดียว
        $ictData = IctSolution::where('type_id', $type_id)->select('province_id', 'income')->get()->groupBy('province_id');
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
            'Simmy_new',
            'Simmy_move',
            'Simmy_count',
            'Simmy_price',
            'Ict_count',
            'Ict_income',
            'types',
            'move',
            'adjust',
            'ictData1',
            'ictSummary',
            'provinceSummary',
            'serviceNames'
        ));
    }

    public function exportActivityList($type_id)
    {
        $type = TypeActivity::where('type_id', $type_id)->first();
        $typeName = $type ? $type->type_name : 'all';
        $filename = 'รายงานกิจกรรมการตลาด_' . $typeName . '_' . date('Y-m-d') . '.xlsx';

        return Excel::download(new EventExport($type_id), $filename);
    }
    public function EventDepartment($type_id)
    {

        // ดึงข้อมูล Province และ TypeActivity
        $provinces = ProvinceActivity::all();
        $types = TypeActivity::where('type_id', $type_id)->first();


        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $fttxData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->whereIn('new', [1, 2]) // ✅ ใช้ whereIn() แทน
            ->get()
            ->groupBy('province_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $adjustData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 0)
            ->get()
            ->groupBy('province_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $moveData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 2)
            ->get()
            ->groupBy('province_id');



        $fttxNew = $fttxData->map(fn($items) => $items->whereIn('new', [1, 2])->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());
        $adjust = $adjustData->map(fn($items) => $items->where('new', 0)->count())->toArray();
        $adjust12 = $adjustData->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id < 13))->count();
        $adjustover12 = $adjustData->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id > 12))->count();
        $move = $moveData->map(fn($items) => $items->where('new', 2)->count())->toArray();
        $move12 = $moveData->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id < 13))->count();
        $moveover12 = $moveData->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id > 12))->count();




        // โหลดข้อมูล Simmy เฉพาะ type_id
        $simmyData = Simmy::where('type_id', $type_id)
            ->select('province_id', 'cus_new')
            ->get()
            ->groupBy('province_id');

        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        // โหลดข้อมูล TopUp เฉพาะ type_id
        $topUpData = TopUp::where('type_id', $type_id)
            ->select('province_id', 'amount')
            ->get()
            ->groupBy('province_id');

        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        // โหลดข้อมูล IctSolution เฉพาะ type_id
        $ictData = IctSolution::where('type_id', $type_id)
            ->select('province_id', 'income')
            ->get()
            ->groupBy('province_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        // คำนวณค่ารวมสำหรับ ตป.1 และ ตป.2
        $sumFttxNew = $sumSelfInstall = $sumHireInstall = 0;
        $sumNew = $sumMove = $sumCount = $sumPrice = 0;
        $IctCount = $IctIncome = 0;

        $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = 0;
        $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0;
        $IctCountOver33 = $IctIncomeOver33 = 0;


        foreach ($provinces as $province) {
            $provinceId = $province->province_id;

            if ($provinceId <= 12) {
                $sumFttxNew += $fttxNew[$provinceId] ?? 0;
                $sumSelfInstall += $selfInstall[$provinceId] ?? 0;
                $sumHireInstall += $HireInstall[$provinceId] ?? 0;

                $sumNew += $Simmy_new[$provinceId] ?? 0;
                $sumMove += $Simmy_move[$provinceId] ?? 0;
                $sumCount += $Simmy_count[$provinceId] ?? 0;
                $sumPrice += $Simmy_price[$provinceId] ?? 0;

                $IctCount += $Ict_count[$provinceId] ?? 0;
                $IctIncome += $Ict_income[$provinceId] ?? 0;
            } else {
                $sumFttxNewOver33 += $fttxNew[$provinceId] ?? 0;
                $sumSelfInstallOver33 += $selfInstall[$provinceId] ?? 0;
                $sumHireInstallOver33 += $HireInstall[$provinceId] ?? 0;

                $sumNewOver33 += $Simmy_new[$provinceId] ?? 0;
                $sumMoveOver33 += $Simmy_move[$provinceId] ?? 0;
                $sumCountOver33 += $Simmy_count[$provinceId] ?? 0;
                $sumPriceOver33 += $Simmy_price[$provinceId] ?? 0;

                $IctCountOver33 += $Ict_count[$provinceId] ?? 0;
                $IctIncomeOver33 += $Ict_income[$provinceId] ?? 0;
            }
        }


        return view('events.events_department', compact(
            'types',
            'provinces',
            'fttxNew',
            'selfInstall',
            'HireInstall',
            'Simmy_new',
            'Simmy_move',
            'Simmy_count',
            'Simmy_price',
            'Ict_count',
            'Ict_income',
            'sumFttxNew',
            'sumSelfInstall',
            'sumHireInstall',
            'sumNew',
            'sumMove',
            'sumCount',
            'sumPrice',
            'IctCount',
            'IctIncome',
            'sumFttxNewOver33',
            'sumSelfInstallOver33',
            'sumHireInstallOver33',
            'sumNewOver33',
            'sumMoveOver33',
            'sumCountOver33',
            'sumPriceOver33',
            'IctCountOver33',
            'IctIncomeOver33',
            'adjust',
            'adjust12',
            'adjustover12',
            'move',
            'move12',
            'moveover12'


        ));
    }


    public function Eventservices($province_id, $type_id)
    {
        $provinces = ($province_id == 1) ?
            ProvinceActivity::where('province_id', '<', 13)->get() :
            ProvinceActivity::where('province_id', '>', 12)->get();
        $types = TypeActivity::where('type_id', $type_id)->first();


        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $fttxData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->whereIn('new', [1, 2]) // ✅ ใช้ whereIn() แทน
            ->get()
            ->groupBy('province_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $adjustData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 0)
            ->get()
            ->groupBy('province_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $moveData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')->where('new', 2)
            ->get()
            ->groupBy('province_id');

        $fttxNew = $fttxData->map(fn($items) => $items->whereIn('new', [1, 2])->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());

        $adjust = $adjustData->map(fn($items) => $items->where('new', 0)->count())->toArray();
        $adjust12 = $adjustData
            ->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id < 13))
            ->groupBy('province_id')
            ->map(fn($items) => $items->count());
        $adjustover12 = $adjustData->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id > 12))
            ->groupBy('province_id')
            ->map(fn($items) => $items->count());

        $move = $moveData->map(fn($items) => $items->where('new', 2)->count())->toArray();
        $move12 = $moveData
            ->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id < 13))
            ->groupBy('province_id')
            ->map(fn($items) => $items->count());
        $moveover12 = $moveData->flatMap(fn($collection) => $collection->filter(fn($item) => $item->province_id > 12))
            ->groupBy('province_id')
            ->map(fn($items) => $items->count());


        // โหลดข้อมูล Simmy เฉพาะ type_id
        $simmyData = Simmy::where('type_id', $type_id)
            ->select('province_id', 'cus_new')
            ->get()
            ->groupBy('province_id');

        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        // โหลดข้อมูล TopUp เฉพาะ type_id
        $topUpData = TopUp::where('type_id', $type_id)
            ->select('province_id', 'amount')
            ->get()
            ->groupBy('province_id');

        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        // โหลดข้อมูล IctSolution เฉพาะ type_id
        $ictData = IctSolution::where('type_id', $type_id)
            ->select('province_id', 'income')
            ->get()
            ->groupBy('province_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        // คำนวณค่ารวมสำหรับ ตป.1 และ ตป.2
        $sumFttxNew = $sumSelfInstall = $sumHireInstall = 0;
        $sumNew = $sumMove = $sumCount = $sumPrice = 0;
        $IctCount = $IctIncome = 0;

        $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = 0;
        $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0;
        $IctCountOver33 = $IctIncomeOver33 = 0;
        $sumAdjust = $sumAdjustOver33 = 0;
        $sumMovefttx = $sumMovefttxOver33 = 0;

        foreach ($provinces as $province) {
            $provinceId = $province->province_id;

            if ($provinceId <= 12) {
                $sumFttxNew += $fttxNew[$provinceId] ?? 0;
                $sumSelfInstall += $selfInstall[$provinceId] ?? 0;
                $sumHireInstall += $HireInstall[$provinceId] ?? 0;

                $sumNew += $Simmy_new[$provinceId] ?? 0;
                $sumMove += $Simmy_move[$provinceId] ?? 0;
                $sumCount += $Simmy_count[$provinceId] ?? 0;
                $sumPrice += $Simmy_price[$provinceId] ?? 0;

                $IctCount += $Ict_count[$provinceId] ?? 0;
                $IctIncome += $Ict_income[$provinceId] ?? 0;
                $sumAdjust +=  $adjust12[$provinceId] ?? 0;
                $sumMovefttx +=  $move12[$provinceId] ?? 0;
            } else {
                $sumFttxNewOver33 += $fttxNew[$provinceId] ?? 0;
                $sumSelfInstallOver33 += $selfInstall[$provinceId] ?? 0;
                $sumHireInstallOver33 += $HireInstall[$provinceId] ?? 0;

                $sumNewOver33 += $Simmy_new[$provinceId] ?? 0;
                $sumMoveOver33 += $Simmy_move[$provinceId] ?? 0;
                $sumCountOver33 += $Simmy_count[$provinceId] ?? 0;
                $sumPriceOver33 += $Simmy_price[$provinceId] ?? 0;

                $IctCountOver33 += $Ict_count[$provinceId] ?? 0;
                $IctIncomeOver33 += $Ict_income[$provinceId] ?? 0;
                $sumAdjustOver33 +=  $adjustover12[$provinceId] ?? 0;
                $sumMovefttxOver33 +=  $moveover12[$provinceId] ?? 0;
            }
        }

        // คำนวณผลรวมทั้งหมด
        $total_all = [
            'sumFttxNew' => $sumFttxNew + $sumFttxNewOver33,
            'sumSelfInstall' => $sumSelfInstall + $sumSelfInstallOver33,
            'sumHireInstall' => $sumHireInstall + $sumHireInstallOver33,
            'sumNew' => $sumNew + $sumNewOver33,
            'sumMove' => $sumMove + $sumMoveOver33,
            'sumCount' => $sumCount + $sumCountOver33,
            'sumPrice' => $sumPrice + $sumPriceOver33,
            'IctCount' => $IctCount + $IctCountOver33,
            'IctIncome' => $IctIncome + $IctIncomeOver33
        ];



        return view('events.events_service', compact(
            'province_id',
            'types',
            'provinces',
            'fttxNew',
            'selfInstall',
            'HireInstall',
            'Simmy_new',
            'Simmy_move',
            'Simmy_count',
            'Simmy_price',
            'Ict_count',
            'Ict_income',
            'sumFttxNew',
            'sumSelfInstall',
            'sumHireInstall',
            'sumNew',
            'sumMove',
            'sumCount',
            'sumPrice',
            'IctCount',
            'IctIncome',
            'sumFttxNewOver33',
            'sumSelfInstallOver33',
            'sumHireInstallOver33',
            'sumNewOver33',
            'sumMoveOver33',
            'sumCountOver33',
            'sumPriceOver33',
            'IctCountOver33',
            'IctIncomeOver33',
            'total_all',
            'adjust',
            'adjust12',
            'adjustover12',
            'move',
            'move12',
            'moveover12',
            'sumAdjust',
            'sumAdjustOver33',
            'sumMovefttx',
            'sumMovefttxOver33'


        ));
    }

    public function Eventcenter($province_id, $type_id)
    {
        // ดึงข้อมูล Province และ TypeActivity
        $centers = ServiceCenterActivity::where('province_id', $province_id)->get();
        $types = TypeActivity::where('type_id', $type_id)->first();
        $provinces = ProvinceActivity::where('province_id', $province_id)->first();

        // โหลดข้อมูล Fttxbroadband เฉพาะ province_id ที่ส่งมา
        $fttxData = Fttxbroadband::where('province_id', $province_id)->where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type', 'center_id')->whereIn('new', [1, 2])
            ->get()
            ->groupBy('center_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $adjustData = Fttxbroadband::where('province_id', $province_id)->where('type_id', $type_id)
            ->select('province_id', 'center_id', 'new', 'installation_type') // ✅ เพิ่ม center_id
            ->where('new', 0)
            ->get()
            ->groupBy('center_id');

        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $moveData = Fttxbroadband::where('province_id', $province_id)->where('type_id', $type_id)
            ->select('province_id', 'center_id', 'new', 'installation_type') // ✅ เพิ่ม center_id
            ->where('new', 2)
            ->get()
            ->groupBy('center_id');


        $fttxNew = $fttxData->map(fn($items) => $items->whereIn('new', [1, 2])->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());
        $adjust = $adjustData->map(fn($items) => $items->count());
        $move = $moveData->map(fn($items) => $items->count());





        // โหลดข้อมูล Simmy เฉพาะ province_id
        $simmyData = Simmy::where('province_id', $province_id)->where('type_id', $type_id)
            ->select('province_id', 'cus_new', 'center_id')
            ->get()
            ->groupBy('center_id');

        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        // โหลดข้อมูล TopUp เฉพาะ province_id
        $topUpData = TopUp::where('province_id', $province_id)->where('type_id', $type_id)
            ->select('province_id', 'amount', 'center_id')
            ->get()
            ->groupBy('center_id');

        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        // โหลดข้อมูล IctSolution เฉพาะ province_id
        $ictData = IctSolution::where('province_id', $province_id)->where('type_id', $type_id)
            ->select('province_id', 'income', 'center_id')
            ->get()
            ->groupBy('center_id');



        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        // คำนวณค่ารวมสำหรับ ตป.1 และ ตป.2
        $sumFttxNew = $sumSelfInstall = $sumHireInstall = 0;
        $sumNew = $sumMove = $sumCount = $sumPrice = 0;
        $IctCount = $IctIncome = 0;
        $sumAdjust = 0;
        $sumMovefttx = 0;


        $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = 0;
        $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0;
        $IctCountOver33 = $IctIncomeOver33 = 0;
        $sumAdjustOver33 = 0;
        $sumMovefttxOver33 = 0;



        foreach ($centers as $center) {
            $centerId = $center->center_id;

            if ($centerId <= 12) {
                $sumFttxNew += $fttxNew[$centerId] ?? 0;
                $sumSelfInstall += $selfInstall[$centerId] ?? 0;
                $sumHireInstall += $HireInstall[$centerId] ?? 0;
                $sumAdjust += $adjust[$centerId] ?? 0;
                $sumMovefttx += $move[$centerId] ?? 0;

                $sumNew += $Simmy_new[$centerId] ?? 0;
                $sumMove += $Simmy_move[$centerId] ?? 0;
                $sumCount += $Simmy_count[$centerId] ?? 0;
                $sumPrice += $Simmy_price[$centerId] ?? 0;

                $IctCount += $Ict_count[$centerId] ?? 0;
                $IctIncome += $Ict_income[$centerId] ?? 0;
            } else {
                $sumFttxNewOver33 += $fttxNew[$centerId] ?? 0;
                $sumSelfInstallOver33 += $selfInstall[$centerId] ?? 0;
                $sumHireInstallOver33 += $HireInstall[$centerId] ?? 0;
                $sumAdjustOver33 += $adjust[$centerId] ?? 0;
                $sumMovefttxOver33 += $move[$centerId] ?? 0;

                $sumNewOver33 += $Simmy_new[$centerId] ?? 0;
                $sumMoveOver33 += $Simmy_move[$centerId] ?? 0;
                $sumCountOver33 += $Simmy_count[$centerId] ?? 0;
                $sumPriceOver33 += $Simmy_price[$centerId] ?? 0;

                $IctCountOver33 += $Ict_count[$centerId] ?? 0;
                $IctIncomeOver33 += $Ict_income[$centerId] ?? 0;
            }
        }

        // คำนวณผลรวมทั้งหมด
        $total_all = [
            'sumFttxNew' => $sumFttxNew + $sumFttxNewOver33,
            'sumSelfInstall' => $sumSelfInstall + $sumSelfInstallOver33,
            'sumHireInstall' => $sumHireInstall + $sumHireInstallOver33,
            'sumNew' => $sumNew + $sumNewOver33,
            'sumMove' => $sumMove + $sumMoveOver33,
            'sumCount' => $sumCount + $sumCountOver33,
            'sumPrice' => $sumPrice + $sumPriceOver33,
            'IctCount' => $IctCount + $IctCountOver33,
            'IctIncome' => $IctIncome + $IctIncomeOver33
        ];






        return view('events.events_center', compact(
            'types',
            'provinces',
            'centers',
            'fttxNew',
            'selfInstall',
            'HireInstall',
            'Simmy_new',
            'Simmy_move',
            'Simmy_count',
            'Simmy_price',
            'Ict_count',
            'Ict_income',
            'sumFttxNew',
            'sumSelfInstall',
            'sumHireInstall',
            'sumNew',
            'sumMove',
            'sumCount',
            'sumPrice',
            'IctCount',
            'IctIncome',
            'sumFttxNewOver33',
            'sumSelfInstallOver33',
            'sumHireInstallOver33',
            'sumNewOver33',
            'sumMoveOver33',
            'sumCountOver33',
            'sumPriceOver33',
            'IctCountOver33',
            'IctIncomeOver33',
            'total_all',
            'ictData',
            'adjust',
            'sumAdjust',
            'sumAdjustOver33',
            'move',
            'sumMovefttx',
            'sumMovefttxOver33',



        ));
    }

    public function EventCustomer(Request $request, $type_id)
    {
        // ดึงข้อมูลลูกค้า และใช้เงื่อนไขการค้นหา
        $query = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])
            ->where('type_id', $type_id);

        // ค้นหาตามชื่อ
        if ($request->has('name') && !empty($request->name)) {
            $query->where('cus_fullname', 'like', '%' . $request->name . '%');
        }

        // ค้นหาตามประเภทบริการ
        if ($request->has('service') && !empty($request->service)) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('service_name', 'like', '%' . $request->service . '%');
            });
        }

        // ค้นหาตามจังหวัด
        if ($request->has('province_id') && !empty($request->province_id)) {
            $query->where('province_id', $request->province_id);
        }

        // ดึงข้อมูลและแบ่งหน้า
        $data = $query->orderBy('cus_id', 'desc')->paginate(10);

        // โหลดข้อมูลเพิ่มเติม (ICT, SIM, FTTX)
        $dataIct = IctSolution::where('type_id', $type_id)->get();
        $provinces = ProvinceActivity::all();
        $types = TypeActivity::where('type_id', $type_id)->get();
        $serviceTypes = ServeActivity::where('type_id', $type_id)->get();

        // ดึงข้อมูลประเภทบริการและจัดกลุ่ม
        $serviceCategories = Customer::with('service')
            ->where('type_id', $type_id)
            ->get()
            ->groupBy('service.service_name');

        $fttxData = Fttxbroadband::select('province_id', 'new', 'installation_type')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $fttxNew = $fttxData->map(fn($items) => $items->where('new', 1)->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());

        $simmyData = Simmy::select('province_id', 'cus_new')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        $topUpData = TopUp::select('province_id', 'amount')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        $ictData = IctSolution::select('province_id', 'income')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        return view('events.events_customer_list', compact(
            'serviceTypes',
            'data',
            'dataIct',
            'provinces',
            'fttxNew',
            'selfInstall',
            'HireInstall',
            'Simmy_new',
            'Simmy_move',
            'Simmy_count',
            'Simmy_price',
            'Ict_count',
            'Ict_income',
            'types',
            'type_id',
            'serviceCategories' // เพิ่มตัวแปรที่จัดกลุ่มข้อมูล
        ));
    }



    public function TopUp_list($type_id)
    {
        $provinces = ProvinceActivity::all();
        $centers = ServiceCenterActivity::all();
        $types = TypeActivity::where('type_id', $type_id)->get();
        $TopUp = TopUp::with(['province', 'center'])->where('type_id', $type_id)->get();


        return view('events.top_up', compact('TopUp', 'provinces', 'centers', 'types'));
    }


    public function searchTopUp(Request $request)
    {
        // รับค่าจาก Request
        $date = $request->input('date');
        $phone = $request->input('phone');
        $service = $request->input('service');
        $province_id = $request->get('province_id');
        $typeCheck = $request->input('type_id');

        // เริ่มต้น query สำหรับการค้นหา
        $query = TopUp::where('type_id', $typeCheck);

        // ตรวจสอบว่า date ไม่ว่าง และกรองข้อมูลตามวันที่
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        // ตรวจสอบว่า phone ไม่ว่าง และกรองข้อมูลตามหมายเลขโทรศัพท์
        if ($phone) {
            $query->where('phone', 'like', '%' . $phone . '%');
        }

        // กรองตาม province_id
        if ($province_id) {
            $query->where('province_id', $province_id);
        }

        // ตรวจสอบว่า service ไม่ว่าง และกรองข้อมูลตามประเภทบริการ
        if ($service) {
            $query->where('type_id', $service);
        }

        // ดึงข้อมูลที่กรองแล้ว
        $topUps = $query->with(['province', 'center'])->get();

        // คืนค่าผลลัพธ์ในรูปแบบ JSON
        return response()->json($topUps);
    }
    public function getProductCenter($center_id, $type_id)
    {
        // ดึงข้อมูล center_name

        $center = ServiceCenterActivity::find($center_id);

        if (!$center) {
            return response()->json(['error' => 'ไม่พบข้อมูลศูนย์บริการ'], 404);
        }

        // ดึงข้อมูล products โดยแยกตาม type_id
        $solutions = IctSolution::where('center_id', $center_id)
            ->where('type_id', $type_id) // กรองข้อมูลตาม type_id
            ->with('products') // โหลดข้อมูลจากความสัมพันธ์ products()
            ->get();



        $productsInfo = [];

        foreach ($solutions as $solution) {
            foreach ($solution->products as $product) {
                $productsInfo[] = [
                    'product_name' => $product->product_name ?? 'ไม่มีข้อมูลสินค้า',
                    'quantity' => $product->pivot->quantity ?? 'ไม่มีข้อมูล',
                    'center_id' => $solution->ict_id ?? 'ไม่มีข้อมูล' // ✅ ดึงจาก IctSolution
                ];
            }
        }

        // ✅ สร้างตัวแปร productCounts แยกต่างหาก
        $productCounts = [];

        foreach ($productsInfo as $product) {
            $productName = $product['product_name'];
            $quantity = $product['quantity'];

            if (!isset($productCounts[$productName])) {
                $productCounts[$productName] = 0;
            }
            $productCounts[$productName] += $quantity;
        }

        // ✅ ส่งค่ากลับไปพร้อม productCounts
        return response()->json([
            'center_name' => $center->center_name,
            'products' => $productsInfo,
            'product_counts' => $productCounts // ✅ แยก productCounts ออกมา ไม่ใส่ใน productsInfo
        ]);
    }

    public function getCustomerDetail($center_id)
    {
        // แปลงค่า $center_ids ที่เป็น string เช่น '1,2,3' ให้อยู่ในรูปแบบ array
        $centerIdsArray = explode(',', $center_id);
        // ดึง cus_id ที่ตรงกับ ict_id จาก IctSolution
        $cusIds = IctSolution::whereIn('ict_id', $centerIdsArray)->pluck('cus_id');

        // ใช้ whereIn เพื่อดึงข้อมูลที่มี center_id ที่ตรงกับ array
        $dataIct = IctSolution::whereIn('ict_id', $centerIdsArray)->get();

        // ใช้ whereIn เพื่อดึงข้อมูลจาก Customer ที่มี cus_id ตรงกับค่าใน $cusIds
        $data = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])->whereIn('cus_id', $cusIds)->get();

        return view('events.detail_center',  compact('data', 'dataIct'));
    }


    public function EventservicesICT($province_id, $type_id)
    {
        $provinces = ($province_id == 1) ?
            ProvinceActivity::where('province_id', '<', 13)->get() :
            ProvinceActivity::where('province_id', '>', 12)->get();

        $provinces1 = ($province_id == 1)
            ? ProvinceActivity::where('province_id', '<', 13)->pluck('province_id')->toArray()
            : ProvinceActivity::where('province_id', '>', 12)->pluck('province_id')->toArray();

        $types = TypeActivity::where('type_id', $type_id)->first();

        // ดึงข้อมูล IctSolution ที่ตรงกับเงื่อนไข
        $ictData1 = IctSolution::where('type_id', $type_id)
            ->whereIn('province_id', $provinces1)
            ->with('products') // โหลด pivot data
            ->get();

        // กำหนดรายการบริการหลัก
        $mainServices = ['CCTV', 'smart pole', 'internet wifi', 'smart office', 'cyber security', 'ultimate connect'];
        $serviceNames = array_merge($mainServices, ['บริการอื่นๆ']);

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
        foreach ($provinces1 as $provinceId) {
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

        // โหลดข้อมูล IctSolution เฉพาะ type_id
        $ictData = IctSolution::where('type_id', $type_id)
            ->select('province_id', 'income')
            ->get()
            ->groupBy('province_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        $IctCount = $IctIncome = 0;
        $IctCountOver33 = $IctIncomeOver33 = 0;

        foreach ($provinces as $province) {
            $provinceId = $province->province_id;
            if ($provinceId <= 12) {
                $IctCount += $Ict_count[$provinceId] ?? 0;
                $IctIncome += $Ict_income[$provinceId] ?? 0;
            } else {
                $IctCountOver33 += $Ict_count[$provinceId] ?? 0;
                $IctIncomeOver33 += $Ict_income[$provinceId] ?? 0;
            }
        }

        // คำนวณผลรวมทั้งหมด
        $total_all = [
            'IctCount' => $IctCount + $IctCountOver33,
            'IctIncome' => $IctIncome + $IctIncomeOver33
        ];

        return view('events.events_service_ict', compact(
            'Ict_count',
            'Ict_income',
            'province_id',
            'types',
            'provinces',
            'IctCount',
            'IctIncome',
            'IctCountOver33',
            'IctIncomeOver33',
            'ictData1',
            'ictSummary',
            'provinceSummary',
            'serviceNames'
        ));
    }

    public function EventcenterICT($province_id, $type_id)
    {
        // ดึงข้อมูล Province และ TypeActivity
        $centers = ServiceCenterActivity::where('province_id', $province_id)->get();
        $types = TypeActivity::where('type_id', $type_id)->first();
        $provinces = ProvinceActivity::where('province_id', $province_id)->first();
        // โหลดข้อมูล IctSolution เฉพาะ province_id
        $ictData = IctSolution::where('province_id', $province_id)->where('type_id', $type_id)
            ->select('province_id', 'income', 'center_id')
            ->get()
            ->groupBy('center_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));
        // คำนวณค่ารวมสำหรับ ตป.1 และ ตป.2
        $IctCount = $IctIncome = 0;
        $IctCountOver33 = $IctIncomeOver33 = 0;
        foreach ($centers as $center) {
            $centerId = $center->center_id;
            if ($centerId <= 12) {
                $IctCount += $Ict_count[$centerId] ?? 0;
                $IctIncome += $Ict_income[$centerId] ?? 0;
            } else {
                $IctCountOver33 += $Ict_count[$centerId] ?? 0;
                $IctIncomeOver33 += $Ict_income[$centerId] ?? 0;
            }
        }
        // คำนวณผลรวมทั้งหมด
        $total_all = [
            'IctCount' => $IctCount + $IctCountOver33,
            'IctIncome' => $IctIncome + $IctIncomeOver33
        ];
        return view('events.events_center_ict', compact(
            'types',
            'provinces',
            'centers',
            'Ict_count',
            'Ict_income',
            'IctCount',
            'IctIncome',
            'IctCountOver33',
            'IctIncomeOver33',
            'total_all',

        ));
    }

    public function EventcenterDetailICT($center_id, $type_id)
    {
        $centers = ServiceCenterActivity::where('center_id', $center_id)->first();
        $ict_service_ids = IctSolution::where('center_id', $center_id)
            ->where('type_id', $type_id)
            ->pluck('ict_service_id')
            ->toArray(); // แปลงเป็น array เพื่อใช้ใน whereIn

        $ict_services = IctService::whereIn('ict_service_id', $ict_service_ids)->get();


        $types = TypeActivity::where('type_id', $type_id)->first();
        // โหลดข้อมูล IctSolution เฉพาะ province_id
        $ictData = IctSolution::where('center_id', $center_id)->where('type_id', $type_id)
            ->select('center_id', 'income', 'ict_service_id')
            ->get()
            ->groupBy('ict_service_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));


        // คำนวณค่ารวมสำหรับ ตป.1 และ ตป.2
        $IctCount = $IctIncome = 0;
        foreach ($ict_services as $ict_service) {
            $serviceId = $ict_service->ict_service_id;
            $IctCount += $Ict_count[$serviceId] ?? 0;
            $IctIncome += $Ict_income[$serviceId] ?? 0;
        }



        return view('events.events_serviceDetail_ict', compact(
            'types',
            'ict_services',
            'centers',
            'Ict_count',
            'Ict_income',
            'IctCount',
            'IctIncome',
            'ictData',
        ));
    }
    public function EventcenterProductICT($ict_service_id, $center_id, $type_id)
    {
        $services = IctService::where('ict_service_id', $ict_service_id)->first();
        $ict_services = IctService::where('ict_service_id', $ict_service_id)->get();
        $types = TypeActivity::where('type_id', $type_id)->first();
        // โหลดข้อมูล IctSolution เฉพาะ province_id
        $ictData = IctSolution::where('ict_service_id', $ict_service_id)->where('type_id', $type_id)->where('center_id', $center_id)
            ->get();


        return view('events.events_serviceProduct_ict', compact(
            'types',
            'ict_services',
            'ictData',
            'services',
            'center_id'
        ));
    }


    public function EventCustomerICT(Request $request, $center_id, $type_id)
    {
        $types = TypeActivity::where('type_id', $type_id)->first();
        $centers = ServiceCenterActivity::where('center_id', $center_id)->first();

        // ดึงข้อมูลลูกค้า และใช้เงื่อนไขการค้นหา
        $query = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])
            ->where('type_id', $type_id)->where('center_id', $center_id);

        // ค้นหาตามชื่อ
        if ($request->has('name') && !empty($request->name)) {
            $query->where('cus_fullname', 'like', '%' . $request->name . '%');
        }

        // ค้นหาตามประเภทบริการ
        if ($request->has('service') && !empty($request->service)) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('service_name', 'like', '%' . $request->service . '%');
            });
        }

        // ค้นหาตามจังหวัด
        if ($request->has('province_id') && !empty($request->province_id)) {
            $query->where('province_id', $request->province_id);
        }

        // ดึงข้อมูลและแบ่งหน้า
        $data = $query->orderBy('cus_id', 'desc')->paginate(10);

        // โหลดข้อมูลเพิ่มเติม (ICT, SIM, FTTX)
        $dataIct = IctSolution::where('type_id', $type_id)->get();
        $provinces = ProvinceActivity::all();
        $serviceTypes = ServeActivity::where('type_id', $type_id)->get();

        // ดึงข้อมูลประเภทบริการและจัดกลุ่ม
        $serviceCategories = Customer::with('service')
            ->where('type_id', $type_id)
            ->get()
            ->groupBy('service.service_name');

        $fttxData = Fttxbroadband::select('province_id', 'new', 'installation_type')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $fttxNew = $fttxData->map(fn($items) => $items->where('new', 1)->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());

        $simmyData = Simmy::select('province_id', 'cus_new')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        $topUpData = TopUp::select('province_id', 'amount')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        $ictData = IctSolution::select('province_id', 'income')
            ->where('type_id', $type_id)->get()->groupBy('province_id');

        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        return view('events.events_customer_ict', compact(
            'serviceTypes',
            'data',
            'dataIct',
            'provinces',
            'fttxNew',
            'selfInstall',
            'HireInstall',
            'Simmy_new',
            'Simmy_move',
            'Simmy_count',
            'Simmy_price',
            'Ict_count',
            'Ict_income',
            'types',
            'type_id',
            'serviceCategories', // เพิ่มตัวแปรที่จัดกลุ่มข้อมูล
            'centers'

        ));
    }
}
