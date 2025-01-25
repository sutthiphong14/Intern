<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Fttxbroadband;
use App\Models\PriceActivity;
use App\Models\PromotionActivity;
use App\Models\ProvinceActivity;
use App\Models\ServeActivity;
use App\Models\ServiceCenterActivity;
use App\Models\Simmy;
use App\Models\SpeedActivity;
use App\Models\TopUp;
use App\Models\TypeActivity;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function CustomerList(Request $request)
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


        return view('events.cus_list', compact('data', 'provinces', 'fttxNew', 'selfInstall', 'HireInstall', 'Simmy_new', 'Simmy_move', 'Simmy_count', 'Simmy_price'));
    }




    public function CustomerCreate()
    {
        $types = TypeActivity::all();
        $services = ServeActivity::all();
        $promotion = PromotionActivity::all();
        $provinces = ProvinceActivity::all();
        $speeds = SpeedActivity::all(); // ดึงข้อมูลความเร็ว
        $prices = PriceActivity::all(); // ดึงข้อมูลราคา
        $centers = ServiceCenterActivity::all(); // ดึงข้อมูลศูนย์บริการ

        return view('events.cus_create', compact('types', 'services', 'promotion', 'provinces', 'speeds', 'prices', 'centers'));
    }




    public function CustomerInsert(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'cus_fullname' => 'required|string',
            'id_card' => 'required|max:13',
            'cus_address' => 'required|string',
            'type_id' => 'required',
            'service_id' => 'required',
            'speed_id' => 'required',
            'price_id' => 'required',
            'province_id' => 'required',
            'center_id' => 'required',
        ], [
            'cus_fullname.required' => 'กรุณากรอกชื่อนามสกุล',
            'id_card.required' => 'กรุณากรอกหมายเลขบัตรประชาชน',
            'id_card.max' => 'หมายเลขบัตรประชาชนต้องไม่เกิน 13 ตัวอักษร',
            'cus_address.required' => 'กรุณากรอกที่อยู่',
            'type_id.required' => 'กรุณาเลือกกิจกรรม',
            'service_id.required' => 'กรุณาเลือกบริการ',
            'speed_id.required' => 'กรุณาเลือกความเร็ว',
            'price_id.required' => 'กรุณาเลือกราคา',
            'province_id.required' => 'กรุณาเลือกจังหวัด',
            'center_id.required' => 'กรุณาเลือกศูนย์บริการ',
        ]);

        // Prepare data for insertion
        $data = $request->only(['cus_fullname', 'id_card', 'cus_address', 'center_id', 'type_id', 'service_id', 'province_id', 'promotion_id', 'speed_id', 'price_id', 'other']);

        if ($request->hasFile('cus_photo')) {
            $file = $request->file('cus_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('customer_images', $filename, 'public');
            $data['cus_photo'] = $path; // เก็บชื่อไฟล์ในฐานข้อมูลตามที่ต้องการ เช่น customer_images/filename
        }

        // Insert into database and retrieve the cus_id from the inserted customer
        $customer = Customer::create($data);

        // ดึงชื่อบริการจาก service_id
        $service_name = ServeActivity::where('service_id', $data['service_id'])->value('service_name');

        if ($service_name == 'fttx_broadband') {
            $new = $request->input('new');
            $installation_type = $request->input('installation_type');
            $cus_id = $customer->id;  // ดึง cus_id ที่เพิ่งสร้างใหม่มาใช้งาน
            $province_id = $request->input('province_id');
            // ใช้ $cus_id ในการเพิ่มข้อมูลใน FttxBroadband
            Fttxbroadband::create([
                'new' => $new,
                'installation_type' => $installation_type,
                'cus_id' => $cus_id, // ใช้ cus_id จากลูกค้าใหม่ที่สร้างมา
                'province_id' => $province_id,
            ]);
        } else if (strpos(strtolower($service_name), 'sim my') !== false) {
            $cus_new = $request->input('cus_new');
            $service_id = $request->input('service_id');
            $price_id = $request->input('price_id');
            $cus_id = $customer->id;  // ดึง cus_id ที่เพิ่งสร้างใหม่มาใช้งาน
            $province_id = $request->input('province_id');
            // ใช้ $cus_id ในการเพิ่มข้อมูลใน FttxBroadband
            Simmy::create([
                'cus_new' => $cus_new,
                'service_id' => $service_id,
                'price_id' => $price_id,
                'cus_id' => $cus_id, // ใช้ cus_id จากลูกค้าใหม่ที่สร้างมา
                'province_id' => $province_id,
            ]);
        }

        return redirect()->route('customer_list')->with('success', 'เพิ่มข้อมูลลูกค้าสำเร็จ');
    }

    public function CustomerDelete($cus_id)
    {
        // Find customer by id
        $customer = Customer::where('cus_id', $cus_id);


        if ($customer) {
            // Delete data from related table (if any)
            Customer::where('cus_id', $cus_id)->delete();

            // Delete the customer
            $customer->delete();

            return redirect()->route('customer_list')->with('success', 'ลบข้อมูลสำเร็จ');
        } else {
            return redirect()->route('customer_list')->with('error', 'Customer not found');
        }
    }

    public function CustomerEdit($cus_id)
    {
        $customer = Customer::where('cus_id', $cus_id)->first();
        if (!$customer) {
            return redirect()->route('customer_list')->with('error', 'ไม่พบข้อมูลลูกค้า');
        }
        $fttxBroadband = Fttxbroadband::where('cus_id', $cus_id)->first();
        $sim_my = Simmy::where('cus_id', $cus_id)->first();
        $customerTypeOptions = Fttxbroadband::select('fttx_id', 'new')->get(); // ตัวเลือกประเภทลูกค้า
        $installationOptions = Fttxbroadband::select('fttx_id', 'installation_type')->get(); // ตัวเลือกวิธีติดตั้ง

        // ดึงข้อมูลประเภทกิจกรรม, บริการ, และจังหวัดเพื่อใช้ในฟอร์ม
        $types = TypeActivity::all();
        $services = ServeActivity::all();
        $promotion = PromotionActivity::all();
        $provinces = ProvinceActivity::all();
        $speed = SpeedActivity::all(); // ดึงข้อมูลความเร็ว
        $prices = PriceActivity::all(); // ดึงข้อมูลราคา
        $centers = ServiceCenterActivity::all(); // ดึงข้อมูลศูนย์บริการ

        return view('events.cus_edit', compact('customer', 'types', 'services', 'promotion', 'provinces', 'speed', 'prices', 'centers', 'fttxBroadband', 'sim_my', 'customerTypeOptions', 'installationOptions'));
    }

    public function CustomerUpdate(Request $request, $cus_id)
    {
        // Find customer by id
        $customer = Customer::where('cus_id', $cus_id)->firstOrFail();

        if (!$customer) {
            return redirect()->route('customer_list')->with('error', 'ไม่พบข้อมูลลูกค้า');
        }

        // รับค่าจากฟอร์ม
        $cus_fullname = $request->input('cus_fullname');
        $id_card = $request->input('id_card');
        $cus_address = $request->input('cus_address');
        $type_id = $request->input('type_id');
        $service_id = $request->input('service_id');

        $province_id = $request->input('province_id');
        $center_id = $request->input('center_id');
        $other = $request->input('other');

        // ตรวจสอบว่ามีไฟล์รูปภาพอัปโหลดไหม
        if ($request->hasFile('cus_photo')) {
            $file = $request->file('cus_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('customer_images', $filename, 'public');
            $cus_photo = $path; // อัปเดตชื่อไฟล์ในฐานข้อมูล
        } else {
            $cus_photo = $customer->cus_photo; // ใช้ค่าที่มีอยู่เดิมหากไม่มีการอัปโหลดรูปใหม่
        }

        // ดึงชื่อบริการจาก service_id
        $service_name = ServeActivity::where('service_id', $service_id)->value('service_name');
        $fttx_cus_id = Fttxbroadband::where('cus_id', $cus_id)->value('cus_id');
        $simmy_cus_id = Simmy::where('cus_id', $cus_id)->value('cus_id');

        if ($service_name == 'fttx_broadband') {
            // กรณีเป็น fttx_broadband
            $new = $request->input('new');
            $installation_type = $request->input('installation_type');
            if ($fttx_cus_id == null) {
                Fttxbroadband::create([
                    'new' => $new,
                    'installation_type' => $installation_type,
                    'cus_id' => $cus_id,
                    'province_id' => $province_id,
                ]);
            } else {
                Fttxbroadband::where('cus_id', $cus_id)->update([
                    'new' => $new,
                    'installation_type' => $installation_type,
                    'province_id' => $province_id
                ]);
            }

            // ลบข้อมูลใน Simmy หากเปลี่ยนจาก sim my
            Simmy::where('cus_id', $cus_id)->delete();
        } elseif (strpos(strtolower($service_name), 'sim my') !== false) {
            // กรณีเป็น sim my
            $cus_new = $request->input('cus_new');
            $price_id = $request->input('price_id');

            if ($simmy_cus_id == null) {
                Simmy::create([
                    'cus_id' => $cus_id,
                    'cus_new' => $cus_new,
                    'service_id' => $service_id,
                    'price_id' => $price_id,
                    'province_id' => $province_id,
                ]);
            } else {
                Simmy::where('cus_id', $cus_id)->update([
                    'cus_new' => $cus_new,
                    'service_id' => $service_id,
                    'price_id' => $price_id,
                    'province_id' => $province_id,
                ]);
            }

            // ลบข้อมูลใน Fttxbroadband หากเปลี่ยนจาก fttx_broadband
            Fttxbroadband::where('cus_id', $cus_id)->delete();
        } else {
            // ลบข้อมูลทั้ง Fttxbroadband และ Simmy หากเปลี่ยนบริการ
            Fttxbroadband::where('cus_id', $cus_id)->delete();
            Simmy::where('cus_id', $cus_id)->delete();
        }

        // อัปเดตข้อมูล
        $updated_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $updateData = [
            'cus_fullname' => $cus_fullname,
            'id_card' => $id_card,
            'cus_address' => $cus_address,
            'type_id' => $type_id,
            'service_id' => $service_id,
            'province_id' => $province_id,
            'center_id' => $center_id,
            'other' => $other,
            'cus_photo' => $cus_photo,
            'updated_at' => $updated_at,
        ];

        $updateResult = Customer::where('cus_id', $cus_id)->update($updateData);

        if ($updateResult) {
            return redirect()->route('customer_list')->with('success', 'อัปเดตข้อมูลลูกค้าเรียบร้อยแล้ว');
        } else {
            return redirect()->route('customer_list')->with('error', 'การอัปเดตล้มเหลว');
        }
    }

    public function insertTopup(Request $request)
    {
        $phone = $request->input('phone');
        $amount = $request->input('amount');
        $province_id = $request->input('province_id');
        $center_id = $request->input('center_id');

        TopUp::create([
            'phone' => $phone,
            'amount' => $amount,
            'province_id' => $province_id, // ใช้ cus_id จากลูกค้าใหม่ที่สร้างมา
            'center_id' => $center_id,
        ]);

        return redirect()->route('customer_list')->with('success', 'เพิ่มข้อมูลการเติมเงินสำเร็จ');
    }




    public function getPromotions(Request $request)
    {
        $serviceId = $request->input('service_id');
        $promotions = PromotionActivity::where('service_id', $serviceId)->get();
        return response()->json($promotions);  // ส่งข้อมูลกลับในรูปแบบ JSON
    }


    public function getSpeeds(Request $request)
    {
        $promotionId = $request->input('promotion_id');
        $speeds = SpeedActivity::where('promotion_id', $promotionId)->get();
        return response()->json($speeds);
    }

    public function getPrices(Request $request)
    {
        $speedId = $request->input('speed_id');
        $prices = PriceActivity::where('speed_id', $speedId)->get();
        return response()->json($prices);
    }

    public function getCenters(Request $request)
    {
        $provinceId = $request->input('province_id');
        $centers = ServiceCenterActivity::where('province_id', $provinceId)->get();
        return response()->json($centers);
    }
}
