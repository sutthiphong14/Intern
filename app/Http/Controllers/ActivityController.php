<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Fttxbroadband;
use App\Models\IctProduct;
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

        // ดึงข้อมูล Fttxbroadband ที่ติดตั้งเอง
        $selfInstall = Fttxbroadband::where('installation_type', 1)
            ->get()
            ->groupBy('type_id')
            ->map(function ($items) {
                return $items->groupBy('province_id')->map(function ($provinceItems) {
                    return $provinceItems->count('installation_type');
                });
            });

        // ดึงข้อมูล Fttxbroadband ที่จ้างผู้รับเหมา
        $HireInstall = Fttxbroadband::where('installation_type', 0)
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

        return view('events.TypeActivityList', compact('data', 'typeActivities', 'sumByType'));
    }

    public function TypeInsert(Request $request)
    {
        $request->validate([
            'type_name' => 'required|string|max:255',
        ]);

        try {
            // บันทึกข้อมูลและเก็บผลลัพธ์
            $newRecord = Typeactivity::create($request->all());

            // ส่งข้อมูลสำเร็จกลับไปในรูปแบบ JSON พร้อม ID
            return response()->json(['success' => true, 'message' => 'เพิ่มกิจกรรมสำเร็จ', 'id' => $newRecord->id]);
        } catch (\Exception $e) {
            // กรณีเกิดข้อผิดพลาด
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
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
    public function ListService()
    {
        $data = ServeActivity::all();

        return view("events.ServeActivityList", compact('data'));
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

        return redirect()->route('service_list')
            ->with('success', 'อัพเดทบริการสำเร็จ!');
    }


    //โปรโมชั่น

    public function ListPromotion($service_id)
    {
        $data = PromotionActivity::where('service_id', $service_id)->get();
        return view('events.promotionActivityList', compact('data', 'service_id'));
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

    //โปรดัก

    public function ListProduct()
    {
        $data = IctProduct::all();
        return view('events.product_list', compact('data'));
    }


    public function ProductInsert(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',

        ]);

        IctProduct::create([
            'product_name' => $request->product_name,
            'description' => $request->description
        ]);
        $data = IctProduct::all();
        return redirect()->route('product_list', compact('data'))
            ->with('success', 'เพิ่มโปรโมชั่นสำเร็จ');
    }

    public function ProductDelete($product_id)
    {
        IctProduct::where('product_id', $product_id)->delete();
        $data = IctProduct::all();
        return redirect()->route('product_list', compact('data'))
            ->with('success', 'ลบโปรโมชั่นสำเร็จ');
    }

    public function ProductUpdate(Request $request, $product_id)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',

        ]);

        IctProduct::where('product_id', $product_id)->update([
            'product_name' => $request->product_name,
            'description' => $request->description
        ]);
        $data = IctProduct::all();
        return redirect()->route('product_list', compact('data'))
            ->with('success', 'อัปเดตโปรโมชั่นสำเร็จ');
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

    public function activity_list(Request $request)
    {
        $type_service = $request->input('type_service');

        // กรองข้อมูล Customer ตาม type_service
        $dataQuery = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center']);
        if ($type_service !== null) {
            $dataQuery->whereHas('service', fn($query) => $query->where('service_name', $type_service));
        }
        $data = $dataQuery->get();

        // ดึงข้อมูล Province และ TypeActivity
        $provinces = ProvinceActivity::all();
        $types = TypeActivity::all();

        // โหลดข้อมูล Fttxbroadband ครั้งเดียว
        $fttxData = Fttxbroadband::select('province_id', 'new', 'installation_type')->get()->groupBy('province_id');

        $fttxNew = $fttxData->map(fn($items) => $items->where('new', 1)->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());

        // โหลดข้อมูล Simmy และ TopUp ครั้งเดียว
        $simmyData = Simmy::select('province_id', 'cus_new')->get()->groupBy('province_id');
        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        $topUpData = TopUp::select('province_id', 'amount')->get()->groupBy('province_id');
        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        // โหลดข้อมูล IctSolution ครั้งเดียว
        $ictData = IctSolution::select('province_id', 'income')->get()->groupBy('province_id');
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
            'types'
        ));
    }


    public function Eventservices($type_id)
    {

        // ดึงข้อมูล Province และ TypeActivity
        $provinces = ProvinceActivity::all();
        $types = TypeActivity::where('type_id', $type_id)->first();


        // โหลดข้อมูล Fttxbroadband เฉพาะ type_id ที่ส่งมา
        $fttxData = Fttxbroadband::where('type_id', $type_id)
            ->select('province_id', 'new', 'installation_type')
            ->get()
            ->groupBy('province_id');

        $fttxNew = $fttxData->map(fn($items) => $items->where('new', 1)->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());

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
            'total_all'


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
            ->select('province_id', 'new', 'installation_type', 'center_id')
            ->get()
            ->groupBy('center_id');

        $fttxNew = $fttxData->map(fn($items) => $items->where('new', 1)->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());

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

        $sumFttxNewOver33 = $sumSelfInstallOver33 = $sumHireInstallOver33 = 0;
        $sumNewOver33 = $sumMoveOver33 = $sumCountOver33 = $sumPriceOver33 = 0;
        $IctCountOver33 = $IctIncomeOver33 = 0;

        foreach ($centers as $center) {
            $centerId = $center->center_id;

            if ($centerId <= 12) {
                $sumFttxNew += $fttxNew[$centerId] ?? 0;
                $sumSelfInstall += $selfInstall[$centerId] ?? 0;
                $sumHireInstall += $HireInstall[$centerId] ?? 0;

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
            'total_all'


        ));
    }

    public function EventCustomer($type_id)
    {
        // กรองข้อมูล Customer ตาม type_service และ type_id
        $dataQuery = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])
            ->where('type_id', $type_id); // เพิ่มเงื่อนไขตาม type_id

        $dataIct = IctSolution::where('type_id',$type_id)->get();
      
        $data = $dataQuery->get();

        

        // ดึงข้อมูล Province และ TypeActivity
        $provinces = ProvinceActivity::all();
        $types = TypeActivity::where('type_id', $type_id)->get(); // กรอง TypeActivity ตาม type_id

        // โหลดข้อมูล Fttxbroadband และกรองตาม type_id
        $fttxData = Fttxbroadband::select('province_id', 'new', 'installation_type')
            ->where('type_id', $type_id) // กรองตาม type_id
            ->get()
            ->groupBy('province_id');

        $fttxNew = $fttxData->map(fn($items) => $items->where('new', 1)->count());
        $selfInstall = $fttxData->map(fn($items) => $items->where('installation_type', 1)->count());
        $HireInstall = $fttxData->map(fn($items) => $items->where('installation_type', 0)->count());

        // โหลดข้อมูล Simmy และกรองตาม type_id
        $simmyData = Simmy::select('province_id', 'cus_new')
            ->where('type_id', $type_id) // กรองตาม type_id
            ->get()
            ->groupBy('province_id');
        $Simmy_new = $simmyData->map(fn($items) => $items->where('cus_new', 1)->count());
        $Simmy_move = $simmyData->map(fn($items) => $items->where('cus_new', 0)->count());

        // โหลดข้อมูล TopUp และกรองตาม type_id
        $topUpData = TopUp::select('province_id', 'amount')
            ->where('type_id', $type_id) // กรองตาม type_id
            ->get()
            ->groupBy('province_id');
        $Simmy_count = $topUpData->map(fn($items) => $items->count());
        $Simmy_price = $topUpData->map(fn($items) => $items->sum('amount'));

        // โหลดข้อมูล IctSolution และกรองตาม type_id
        $ictData = IctSolution::select('province_id', 'income')
            ->where('type_id', $type_id) // กรองตาม type_id
            ->get()
            ->groupBy('province_id');
        $Ict_count = $ictData->map(fn($items) => $items->count());
        $Ict_income = $ictData->map(fn($items) => $items->sum('income'));

        // ดึงข้อมูลประเภทบริการ
        $serviceTypes = ServeActivity::all();

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
            'types'
        ));
    }

    public function TopUp_list()
    {
        $provinces = ProvinceActivity::all();
        $centers = ServiceCenterActivity::all();
        $types = TypeActivity::all();
        $TopUp = TopUp::with(['province', 'center'])->get();
        return view('events.top_up', compact('TopUp', 'provinces', 'centers', 'types'));
    }

    public function searchTopUp(Request $request)
    {
        // รับค่าจาก Request
        $date = $request->input('date');
        $phone = $request->input('phone');
        $service = $request->input('service');
        $province_id = $request->get('province_id');

        // เริ่มต้น query สำหรับการค้นหา
        $query = TopUp::query();

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
}
