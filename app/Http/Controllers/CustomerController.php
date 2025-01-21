<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\PriceActivity;
use App\Models\PromotionActivity;
use App\Models\ProvinceActivity;
use App\Models\ServeActivity;
use App\Models\ServiceCenterActivity;
use App\Models\SpeedActivity;
use App\Models\TypeActivity;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function CustomerList()
    {
        $data = Customer::with(['type', 'service', 'promotion', 'province', 'speed', 'price', 'center'])->get();
        return view('events.cus_list', compact('data'));
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
            'cus_fullname' => 'required|string|max:255',
            'id_card' => 'required|max:13',
            'cus_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cus_address' => 'required|string|max:500',
            'type_id' => 'required|exists:type_activity,type_id',
            'province_id' =>'required',
            'center_id'=> 'required'
        ]);

        // Prepare data for insertion
        $data = $request->only(['cus_fullname', 'id_card', 'cus_address', 'center_id', 'type_id', 'service_id', 'province_id', 'promotion_id', 'speed_id', 'price_id', 'other']);

        if ($request->hasFile('cus_photo')) {
            $file = $request->file('cus_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('customer_images', $filename, 'public');
            $data['cus_photo'] = $path; // เก็บชื่อไฟล์ในฐานข้อมูลตามที่ต้องการ เช่น customer_images/filename
        }


        // Insert into database
        Customer::create($data);

        return redirect()->route('customer_list')->with('success', 'เพิ่มข้อมูลลูกค้าสำเร็จ');
    }

    public function CustomerDelete($cus_id)
    {
        // Find customer by id
        $customer = Customer::find($cus_id);

        if ($customer) {
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

        // ดึงข้อมูลประเภทกิจกรรม, บริการ, และจังหวัดเพื่อใช้ในฟอร์ม
        $types = TypeActivity::all();
        $services = ServeActivity::all();
        $promotion = PromotionActivity::all();
        $provinces = ProvinceActivity::all();
        $speed = SpeedActivity::all(); // ดึงข้อมูลความเร็ว
        $prices = PriceActivity::all(); // ดึงข้อมูลราคา
        $centers = ServiceCenterActivity::all(); // ดึงข้อมูลศูนย์บริการ

        return view('events.cus_edit', compact('customer', 'types', 'services', 'promotion', 'provinces', 'speed', 'prices', 'centers'));
    }

    public function CustomerUpdate(Request $request, $cus_id)
    {
        // Find customer by ID
        $customer = Customer::find($cus_id);

        if (!$customer) {
            return redirect()->route('customer_list')->with('error', 'ไม่พบข้อมูลลูกค้า');
        }

        // รับค่าจากฟอร์ม
        $customer->cus_fullname = $request->input('cus_fullname');
        $customer->id_card = $request->input('id_card');
        $customer->cus_address = $request->input('cus_address');
        $customer->type_id = $request->input('type_id');
        $customer->service_id = $request->input('service_id');

        // รองรับ null สำหรับ province_id และ center_id
        $customer->province_id = $request->input('province_id') == "null" ? null : $request->input('province_id');
        $customer->center_id = $request->input('center_id') == "null" ? null : $request->input('center_id');
        $customer->other = $request->input('other');

        // ตรวจสอบว่ามีไฟล์รูปภาพอัปโหลดไหม
        if ($request->hasFile('cus_photo')) {
            $file = $request->file('cus_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('customer_images', $filename, 'public');
            $customer->cus_photo = $path; // อัปเดตชื่อไฟล์ในฐานข้อมูล
        }

        // อัปเดตข้อมูล
        $customer->updated_at = \Carbon\Carbon::now();

        // Save to database
        $customer->save();

        return redirect()->route('customer_list')->with('success', 'อัปเดตข้อมูลลูกค้าเรียบร้อยแล้ว');
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
