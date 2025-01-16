<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\ProvinceActivity;
use App\Models\ServeActivity;
use App\Models\Typeactivity;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function CustomerList()
    {
        $data = Customer::with(['type', 'service', 'province', 'speed', 'price', 'center'])->get();
        return view('customers.cus_list', compact('data'));
    }
    
    

    public function CustomerCreate()
    {
        $types = Typeactivity::all();
        $services = ServeActivity::all();
        $provinces = ProvinceActivity::all();
    
        return view('customers.cus_create', compact('types', 'services', 'provinces'));
    }

    public function CustomerInsert(Request $request){
        // Validate the incoming request
        $request->validate([
            'cus_fullname' => 'required|string|max:255',
            'id_card' => 'required|unique:customers,id_card|max:13',
            'cus_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cus_address' => 'required|string|max:500',
            'type_id' => 'required|exists:type_activity,type_id',
            'service_id' => 'required|exists:serve_activity,service_id',
            'province_id' => 'required|exists:province_activity,province_id',
        ]);
    
        // Prepare data for insertion
        $data = $request->only(['cus_fullname', 'id_card', 'cus_address', 'type_id', 'service_id', 'province_id']);
        
        if ($request->hasFile('cus_photo')) {
            $photoPath = $request->file('cus_photo')->store('public/photos');
            $data['cus_photo'] = basename($photoPath); // Save file name
        }
    
        // Insert into database
        Customer::create($data);
    
        return redirect()->route('customer_list')->with('success', 'Customer added successfully');
    }

    public function CustomerDelete($cus_id){
        // Find customer by id
        $customer = Customer::find($cus_id);
        
        if ($customer) {
            // Delete the customer
            $customer->delete();
            return redirect()->route('customer_list')->with('success', 'Customer deleted successfully');
        } else {
            return redirect()->route('customer_list')->with('error', 'Customer not found');
        }
    }

    public function CustomerEdit($cus_id){
        $customer = Customer::where('cus_id', $cus_id)->first();
        if (!$customer) {
            return redirect()->route('customer_list')->with('error', 'ไม่พบข้อมูลลูกค้า');
        }
    
        // ดึงข้อมูลประเภทกิจกรรม, บริการ, และจังหวัดเพื่อใช้ในฟอร์ม
        $types = Typeactivity::all();
        $services = ServeActivity::all();
        $provinces = ProvinceActivity::all();
    
        return view('customers.cus_edit', compact('customer', 'types', 'services', 'provinces'));
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
        $customer->province_id = $request->input('province_id');
    
        // ตรวจสอบว่ามีไฟล์รูปภาพอัปโหลดไหม
        if ($request->hasFile('cus_photo')) {
            $file = $request->file('cus_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads/customers', $filename, 'public');
            $customer->cus_photo = $path; // อัปเดตชื่อไฟล์ในฐานข้อมูล
        }
    
        // อัปเดตข้อมูล
        $customer->updated_at = \Carbon\Carbon::now();
        
        // Save to database
        $customer->save();
    
        return redirect()->route('customer_list')->with('success', 'อัปเดตข้อมูลลูกค้าเรียบร้อยแล้ว');
    }
    
    
    
    
    
}
