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
use App\Models\SpeedActivity;
use App\Models\TypeActivity;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Web\Service;

class ActivityController extends Controller
{
    //กิจกรรม
    public function ListType()
    {
        $data = Typeactivity::all();

        return view('events.TypeActivityList', compact('data'));
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
        // รับค่า type_service จาก request (GET หรือ POST)
        $type_service = $request->input('type_service');

        // กรองข้อมูลตาม type_service
        if ($type_service !== null) {
            // กรองข้อมูลตามชื่อบริการในตาราง service
            $data = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])
                ->whereHas('service', function ($query) use ($type_service) {
                    $query->where('service_name', $type_service);
                })
                ->get();
        } else {
            // หากไม่เลือก type_service ให้ดึงข้อมูลทั้งหมด
            $data = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])->get();
        }

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

        $serviceTypes = ServeActivity::all(); // หรือสามารถใช้ where หรือ query อื่นๆ ได้ตามต้องการ

        $Ict_count = IctSolution::all()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count(); // นับจำนวนรายการในแต่ละกลุ่ม
            });

        $Ict_income = IctSolution::all()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->sum('income'); // รวมค่าของ amount ในแต่ละกลุ่ม
            });
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
            'Ict_income'
        ));
    }

    public function activityView(){

        $data = Typeactivity::all();
        return view('events.activity_view', compact('data'));
    }
}
