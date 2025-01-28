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
        $centers = ServiceCenterActivity::all();

        // ดึงข้อมูล Fttxbroadband ที่ new = 1
        $fttxNew = Customer::where('cus_type_fttx', 1)
            ->get()
            ->groupBy('province_id') // แยกกลุ่มตาม `province_id`
            ->map(function ($items) {
                return $items->count('new'); // รวมค่าที่ซ้ำกันได้
            });


        // ดึงข้อมูล Fttxbroadband ที่ติดตั้งเอง
        $selfInstall = Customer::where('installation_type', 1)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('installation_type'); // รวมค่าที่ซ้ำกันได้
            });

        // ดึงข้อมูล Fttxbroadband ที่จ้างผู้รับเหมา
        $HireInstall = Customer::where('installation_type', 0)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('installation_type'); // รวมค่าที่ซ้ำกันได้
            });

        $Simmy_new = Customer::where('cus_type_sim', 1)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('cus_type_sim'); // รวมค่าที่ซ้ำกันได้
            });

        $Simmy_move = Customer::where('cus_type_sim', 0)
            ->get()
            ->groupBy('province_id')
            ->map(function ($items) {
                return $items->count('cus_type_sim'); // รวมค่าที่ซ้ำกันได้
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

        $TopUp = TopUp::with(['province', 'center'])->get();



        return view('events.cus_list', compact('data', 'provinces', 'centers', 'fttxNew', 'selfInstall', 'HireInstall', 'Simmy_new', 'Simmy_move', 'Simmy_count', 'Simmy_price', 'TopUp'));
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
        
        $service = $request->input('service_id');



        // ดึงชื่อบริการจาก service_id
        $service_name = ServeActivity::where('service_id', $service)->value('service_name');

        if (strpos(strtolower($service_name), 'fttx_broadband') !== false) {
            // Prepare data for insertion
            $data = $request->only([
                'cus_fullname', 'id_card', 'cus_address', 'center_id', 'type_id', 
                'service_id', 'installation_type', 'cus_type_fttx', 'province_id', 
                'promotion_id', 'speed_id', 'price_id', 'other'
            ]);
            if ($request->hasFile('cus_photo')) {
                $file = $request->file('cus_photo');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('customer_images', $filename, 'public');
                $data['cus_photo'] = $path; // เพิ่มข้อมูลลงใน $data
            }
            // Insert into database and retrieve the cus_id from the inserted customer
            $customer = Customer::create($data);
        } else if (strpos(strtolower($service_name), 'sim my') !== false) {
                // Prepare data for insertion
                $data = $request->only([
                    'cus_fullname', 'id_card', 'cus_address', 'center_id', 'type_id', 
                    'service_id', 'cus_type_sim', 'province_id', 
                    'promotion_id', 'speed_id', 'price_id', 'other'
                ]);
                if ($request->hasFile('cus_photo')) {
                    $file = $request->file('cus_photo');
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $path = $file->storeAs('customer_images', $filename, 'public');
                    $data['cus_photo'] = $path; // เพิ่มข้อมูลลงใน $data
                }
                // Insert into database and retrieve the cus_id from the inserted customer
                $customer = Customer::create($data);
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
        $fttxBroadband = Customer::where('cus_id', $cus_id)->first();
        $sim_my = Customer::where('cus_id', $cus_id)->first();
        $customerTypeOptions = Customer::select('cus_id', 'cus_type_fttx')->get() ; // ตัวเลือกประเภทลูกค้า
        $installationOptions = Customer::select('cus_id', 'installation_type')->get(); // ตัวเลือกวิธีติดตั้ง

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
        $cus_type_fttx = $request->input('cus_type_fttx');
        $cus_type_sim = $request->input('cus_type_sim');
        $installation_type = $request->input('installation_type');
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

        // อัปเดตข้อมูล
        $updated_at = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        $updateData = [
            'cus_fullname' => $cus_fullname,
            'id_card' => $id_card,
            'cus_address' => $cus_address,
            'type_id' => $type_id,
            'service_id' => $service_id,
            'cus_type_fttx' => $cus_type_fttx,
            'installation_type' => $installation_type,
            'cus_type_sim' => $cus_type_sim,
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

    public function TopUpDelete($topUp_id)
    {
        // Find customer by id
        $customer = TopUp::where('topUp_id', $topUp_id);


        if ($customer) {
            // Delete data from related table (if any)
            TopUp::where('topUp_id', $topUp_id)->delete();

            // Delete the customer
            $customer->delete();

            return redirect()->route('customer_list')->with('success', 'ลบข้อมูลสำเร็จ');
        } else {
            return redirect()->route('customer_list')->with('error', 'Customer not found');
        }
    }
    public function getTopUpDetails($topUpId)
    {
        $topUp = TopUp::findOrFail($topUpId);
        $provinces = ProvinceActivity::all();
        $centers = ServiceCenterActivity::all();

        return response()->json([
            'phone' => $topUp->phone,
            'amount' => $topUp->amount,
            'province_id' => $topUp->province_id,
            'center_id' => $topUp->center_id,
            'provinces' => $provinces, // หากคุณต้องการส่ง provinces และ centers กลับไป
            'centers' => $centers
        ]);
    }



    public function TopUpUpdate(Request $request, $id)
    {
        $request->validate([
            'phone' => 'string|max:255',
            'amount' => 'required|numeric',
            'province_id' => 'required',
            'center_id' => 'required'
        ]);

        $topUp = TopUp::where('topUp_id', $id);

        $topUp->update([
            'phone' => $request->phone,
            'amount' => $request->amount,
            'province_id' => $request->province_id,
            'center_id' => $request->center_id,
        ]);

        return redirect()->back()->with('success', 'TopUp updated successfully!');
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

    public function searchCustomers(Request $request)
    {
        $date = $request->get('date');
        $name = $request->get('name');
        $service = $request->get('service');

        // เริ่มต้น Query
        $query = Customer::query();

        // ค้นหาตามวันที่
        if ($date) {
            $query->whereDate('created_at', $date);
        }

        // ค้นหาตามชื่อ
        if ($name) {
            $query->where('cus_fullname', 'like', '%' . $name . '%');
        }

        // ค้นหาตามประเภทบริการ
        if ($service) {
            $query->whereHas('service', function ($q) use ($service) {
                $q->where('service_name', 'like', '%' . $service . '%');
            });
        }

        // ดึงข้อมูลลูกค้า
        $customers = $query->with(['type', 'service', 'promotion', 'speed', 'price', 'province', 'center'])->get();

        return response()->json($customers);
    }
}
