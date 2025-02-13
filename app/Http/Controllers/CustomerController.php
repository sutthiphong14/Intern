<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Fttxbroadband;
use App\Models\IctProduct;
use App\Models\IctSolution;
use App\Models\PriceActivity;
use App\Models\PromotionActivity;
use App\Models\ProvinceActivity;
use App\Models\ServeActivity;
use App\Models\ServiceCenterActivity;
use App\Models\Simmy;
use App\Models\SpeedActivity;
use App\Models\TopUp;
use App\Models\TypeActivity;
use Carbon\Carbon;
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

        $TopUp = TopUp::with(['province', 'center'])->get();

        // $ictSolution = IctSolution::with('products')->find(9)->first(); //




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
        $products = IctProduct::all();

        return view('events.cus_create', compact('types', 'services', 'promotion', 'provinces', 'speeds', 'prices', 'centers', 'products'));
    }




    public function CustomerInsert(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'cus_fullname' => 'required|string',

            'cus_address' => 'required|string',
            'type_id' => 'required',
            'service_id' => 'required',
            'province_id' => 'required',
            'center_id' => 'required',
        ], [
            'cus_fullname.required' => 'กรุณากรอกชื่อนามสกุล',
            'cus_address.required' => 'กรุณากรอกที่อยู่',
            'type_id.required' => 'กรุณาเลือกกิจกรรม',
            'service_id.required' => 'กรุณาเลือกบริการ',
            'province_id.required' => 'กรุณาเลือกจังหวัด',
            'center_id.required' => 'กรุณาเลือกศูนย์บริการ',
        ]);

        // Prepare data for insertion
        $data = $request->only(['cus_fullname', 'id_card', 'cus_address', 'center_id', 'type_id', 'service_id', 'province_id', 'promotion_id', 'speed_id', 'price_id', 'other']);
        $data['created_at'] = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::now(); // ถ้า date ในฟอร์มมีค่าให้ใช้ ถ้าไม่มีใช้เวลาปัจจุบัน

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


        if (strpos(strtolower($service_name), 'fttx_broadband') !== false) {
            $new = $request->input('new');
            $installation_type = $request->input('installation_type');
            $cus_id = $customer->id;  // ดึง cus_id ที่เพิ่งสร้างใหม่มาใช้งาน
            $type_id = $request->input('type_id');
            $center = $request->input('center_id');
            $province_id = $request->input('province_id');
            $date = $request->input('date');
            // ใช้ $cus_id ในการเพิ่มข้อมูลใน FttxBroadband

            Fttxbroadband::create([
                'new' => $new,
                'installation_type' => $installation_type,
                'cus_id' => $cus_id, // ใช้ cus_id จากลูกค้าใหม่ที่สร้างมา
                'type_id' => $type_id,
                'center_id' => $center,
                'province_id' => $province_id,
                'created_at' => $date
            ]);
        } else if (strpos(strtolower($service_name), 'sim my') !== false) {
            $cus_new = $request->input('cus_new');
            $service_id = $request->input('service_id');
            $price_id = $request->input('price_id');
            $cus_id = $customer->id;  // ดึง cus_id ที่เพิ่งสร้างใหม่มาใช้งาน
            $type_id = $request->input('type_id');
            $center = $request->input('center_id');
            $province_id = $request->input('province_id');
            $date = $request->input('date');
            // ใช้ $cus_id ในการเพิ่มข้อมูลใน FttxBroadband
            Simmy::create([
                'cus_new' => $cus_new,
                'service_id' => $service_id,
                'price_id' => $price_id,
                'cus_id' => $cus_id, // ใช้ cus_id จากลูกค้าใหม่ที่สร้างมา
                'type_id' => $type_id,
                'center_id' => $center,
                'province_id' => $province_id,
                'created_at' => $date
            ]);
        } elseif (strpos(strtolower($service_name), 'ict solution') !== false) {
            // ตัวแปรสำหรับไฟล์ quote
            $filePath = null;
            if ($request->hasFile('quote')) {
                $filePath = $request->file('quote')->store('quotes', 'public');
            }

            // สร้าง IctSolution
            $ictSolution = IctSolution::create([
                'income' => $request->input('income'),
                'cus_id' => $customer->id,
                'type_id' => $request->input('type_id'),
                'center_id' => $request->input('center_id'),
                'province_id' => $request->input('province_id'),
                'quote' => $filePath,
                'customer_type' => $request->input('customer_type'),
                'created_at' => $request->input('date')
            ]);

            // ✅ เพิ่ม Products ที่เกี่ยวข้องกับ ICT Solution
            $product_ids = $request->input('product_id'); // รับค่า product_id เป็น array
            $quantities = $request->input('quantity'); // รับค่า quantity เป็น array

            if (!empty($product_ids) && !empty($quantities)) {
                foreach ($product_ids as $index => $product_id) {
                    $product = IctProduct::where('product_id', $product_id);
                    $quantity = $quantities[$index];

                    $ictSolution->products()->attach($product_id, [
                        'quantity' => $quantity

                    ]);
                }
            }
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
        $ict_solution = IctSolution::where('cus_id', $cus_id)->first();
        $customerTypeOptions = Fttxbroadband::select('fttx_id', 'new')->get(); // ตัวเลือกประเภทลูกค้า
        $installationOptions = Fttxbroadband::select('fttx_id', 'installation_type')->get(); // ตัวเลือกวิธีติดตั้ง

        $ict_solution = IctSolution::with('products')->where('cus_id', $cus_id)->first();
        // ตรวจสอบก่อนว่ามี ICT Solution หรือไม่
        $productsWithQuantity = $ict_solution ? $ict_solution->products : collect();


        // ดึงข้อมูลประเภทกิจกรรม, บริการ, และจังหวัดเพื่อใช้ในฟอร์ม
        $types = TypeActivity::all();
        $services = ServeActivity::all();
        $promotion = PromotionActivity::all();
        $provinces = ProvinceActivity::all();
        $speed = SpeedActivity::all(); // ดึงข้อมูลความเร็ว
        $prices = PriceActivity::all(); // ดึงข้อมูลราคา
        $centers = ServiceCenterActivity::all(); // ดึงข้อมูลศูนย์บริการ
        $products = IctProduct::all();


        return view('events.cus_edit', compact('products', 'customer', 'types', 'services', 'promotion', 'provinces', 'speed', 'prices', 'centers', 'fttxBroadband', 'sim_my', 'ict_solution', 'productsWithQuantity', 'customerTypeOptions', 'installationOptions'));
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
        $date = $request->input('date');
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

        if (strpos(strtolower($service_name), 'fttx_broadband') !== false) {
            // กรณีเป็น fttx_broadband
            $new = $request->input('new');
            $installation_type = $request->input('installation_type');
            if ($fttx_cus_id == null) {
                Fttxbroadband::create([
                    'new' => $new,
                    'installation_type' => $installation_type,
                    'cus_id' => $cus_id,
                    'center_id' => $center_id,
                    'province_id' => $province_id,
                    'type_id' => $type_id,
                    'created_at' => $date
                ]);
            } else {
                Fttxbroadband::where('cus_id', $cus_id)->update([
                    'new' => $new,
                    'installation_type' => $installation_type,
                    'center_id' => $center_id,
                    'province_id' => $province_id,
                    'type_id' => $type_id,
                    'updated_at' => $date
                ]);
            }

            // ลบข้อมูลใน Simmy หากเปลี่ยนจาก sim my
            Simmy::where('cus_id', $cus_id)->delete();
            IctSolution::where('cus_id', $cus_id)->delete();
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
                    'center_id' => $center_id,
                    'province_id' => $province_id,
                    'type_id' => $type_id,
                    'created_at' => $date
                ]);
            } else {
                Simmy::where('cus_id', $cus_id)->update([
                    'cus_new' => $cus_new,
                    'service_id' => $service_id,
                    'price_id' => $price_id,
                    'center_id' => $center_id,
                    'province_id' => $province_id,
                    'type_id' => $type_id,
                    'updated_at' => $date
                ]);
            }

            // ลบข้อมูลใน Fttxbroadband หากเปลี่ยนจาก fttx_broadband
            Fttxbroadband::where('cus_id', $cus_id)->delete();
            IctSolution::where('cus_id', $cus_id)->delete();
        } else {
            // อัปเดตข้อมูลใน ict_solution
            $ict_solution = IctSolution::where('cus_id', $cus_id)->first();

            if ($ict_solution) {
                // อัปเดตข้อมูลใน pivot table
                if ($request->has('product_id')) {
                    $product_ids = $request->input('product_id');
                    $quantities = $request->input('quantity');

                    // สร้าง array ที่จะ sync
                    $pivot_data = [];
                    foreach ($product_ids as $index => $product_id) {
                        $pivot_data[$product_id] = ['quantity' => $quantities[$index]];
                    }

                    // ใช้ sync เพื่ออัปเดต pivot table
                    $ict_solution->products()->sync($pivot_data);
                }


                // อัปเดตฟิลด์รายได้
                $ict_solution->update([
                    'income' => $request->input('income'),
                    'customer_type' => $request->input('customer_type'),
                    'quote' => $request->hasFile('quote') ? $request->file('quote')->store('quotes', 'public') : $ict_solution->quote,
                    'center_id' => $center_id,
                    'province_id' => $province_id,
                    'type_id' => $type_id,
                    'updated_at' => $date
                ]);
            } else {
                // ถ้ายังไม่มีข้อมูลใน ict_solution ให้สร้างใหม่
                $ict_solution = IctSolution::create([
                    'cus_id' => $cus_id,
                    'income' => $request->input('income'),
                    'customer_type' => $request->input('customer_type'),
                    'quote' => $request->hasFile('quote') ? $request->file('quote')->store('quotes', 'public') : null,
                    'center_id' => $center_id,
                    'province_id' => $province_id,
                    'type_id' => $type_id,
                    'created_at' => $date
                ]);
            
                // กรณีที่ต้องการอัปเดตข้อมูลของ Customer
                Customer::where('cus_id', $cus_id)->update([
                    'id_card' => null,
                    'cus_photo' => null,
                    'promotion_id' => null,
                    'speed_id' => null,
                    'price_id' => null,
                ]);
            
                // ✅ เพิ่ม Products ที่เกี่ยวข้องกับ ICT Solution
                $product_ids = $request->input('product_id'); // รับค่า product_id เป็น array
                $quantities = $request->input('quantity'); // รับค่า quantity เป็น array
            
                if (!empty($product_ids) && !empty($quantities)) {
                    foreach ($product_ids as $index => $product_id) {
                        $quantity = $quantities[$index];
            
                        // ใช้ attach เพื่อเพิ่มข้อมูลใน pivot table
                        $ict_solution->products()->attach($product_id, [
                            'quantity' => $quantity
                        ]);
                    }
                }
            }
            
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
            'created_at' => $date,
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
