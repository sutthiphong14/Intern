<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\ProvinceActivity;
use App\Models\ServiceCenterActivity;
class UserController extends Controller
{

    public function listUsers()
    {
        $users = User::with(['province', 'serviceCenter'])->paginate(10);
        return view('users.listusers', compact('users'));
    }


    function delete($id)
    {
        $user = User::findOrFail($id); // ค้นหา User โดยใช้ Eloquent
        $user->delete();              // ลบผ่าน Eloquent ซึ่งจะเรียก Observer
        return redirect('/users');
    }

    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่รับเข้ามา
        $validatedData = $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required|string',
            'emp_id' => 'required|string',
            'department' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'province_id' => 'required|exists:province_activity,province_id',
            'center_id' => 'nullable|exists:servicecenter_activity,center_id',
        ]);

        // ถ้ามีการอัพโหลดรูปโปรไฟล์
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageData = base64_encode(file_get_contents($image));
            $imageSrc = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . $imageData;
        }

        // ดึงค่าจาก checkbox permissions ที่ส่งมาจากฟอร์ม
        $permissions = [
            'adminper_mission' => $request->has('adminper_mission') ? 1 : 0,
            'manage_users' => $request->has('manage_users') ? 1 : 0,

            'manage_dashboard' => $request->has('manage_dashboard') ? 1 : 0,
            'view_fttx' => $request->has('view_fttx') ? 1 : 0,

            'managenews_feeds' => $request->has('managenews_feeds') ? 1 : 0,

            'manage_banner' => $request->has('manage_banner') ? 1 : 0,
            'manage_imageevent' => $request->has('manage_imageevent') ? 1 : 0,

            'manage_formevent' => $request->has('manage_formevent') ? 1 : 0,
            'form_event' => $request->has('form_event') ? 1 : 0,
            'view_customer' => $request->has('view_customer') ? 1 : 0,
        ];

        // สร้างผู้ใช้ใหม่ในฐานข้อมูล
        $user = User::create([
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'emp_id' => $validatedData['emp_id'],
            'department' => $validatedData['department'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_image' => $imageSrc ?? null,
            'province_id' => $validatedData['province_id'],
            'center_id' => $request->has('center_id') && is_numeric($request->center_id) ? $request->center_id : null,
            'permission' => $permissions, // ใช้ permission ที่รับมาจากฟอร์ม
        ]);
        
        // ส่งกลับไปยังหน้า user list พร้อมข้อความสำเร็จ
        return redirect()->route('users.list')->with('success', 'เพิ่มผู้ใช้สำเร็จ!');
    }


    public function edit($id)
{
    $user = User::findOrFail($id); // ดึงข้อมูล user ตาม ID ที่ส่งมา
    $provinces = ProvinceActivity::all();
    $centers = ServiceCenterActivity::where('province_id', $user->province_id)->get();
    
    return view('users.editusers', compact('user', 'provinces', 'centers'));
}

    public function editprofile()
    {
        $user = auth()->user(); // ดึงข้อมูลของผู้ใช้ที่ล็อกอินอยู่
        $provinces = ProvinceActivity::all();
        $centers = ServiceCenterActivity::where('province_id', $user->province_id)->get();

        return view('profileedit', compact('user', 'provinces', 'centers')); // เปลี่ยนชื่อ view
    }


    





    public function update(Request $request, $id)
    {
        // ค้นหาผู้ใช้ที่ต้องการอัปเดต
        $user = User::findOrFail($id);

        // อัปเดต validation
        $validatedData = $request->validate([
            'username' => ['required', 'unique:users,username,' . $id],  // Exclude current user from unique check
            'email' => ['required', 'email', 'unique:users,email,' . $id], // Exclude current user from unique check
            'name' => 'required|string|max:255|unique:users,name,' . $id, // Exclude current user from unique check
            'emp_id' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'province_id' => 'required|exists:province_activity,province_id',
            'center_id' => 'nullable|exists:servicecenter_activity,center_id',
            'password' => 'nullable|min:6',
        ]);

        // อัปเดตข้อมูลพื้นฐาน
        $user->update([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'emp_id' => $validatedData['emp_id'],
            'department' => $validatedData['department'],
            'province_id' => $validatedData['province_id'],
            'center_id' => $request->has('center_id') && is_numeric($request->center_id) ? $request->center_id : null,
        ]);

        // อัปเดตรหัสผ่านถ้ามีการส่งค่าใหม่
        if ($request->filled('password')) {
            $user->password = Hash::make($validatedData['password']);
        }

        // อัปเดตรูปภาพถ้ามีการอัปโหลดใหม่
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageData = base64_encode(file_get_contents($image));
            $imageSrc = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . $imageData;
            $user->profile_image = $imageSrc;
        }

        // อัปเดตสิทธิ์การใช้งานให้ตรงกับ store()
        $permissions = [
            'adminper_mission' => $request->has('adminper_mission') ? 1 : 0,
            'manage_users' => $request->has('manage_users') ? 1 : 0,
            'manage_dashboard' => $request->has('manage_dashboard') ? 1 : 0,
            'view_fttx' => $request->has('view_fttx') ? 1 : 0,
            'managenews_feeds' => $request->has('managenews_feeds') ? 1 : 0,
            'manage_banner' => $request->has('manage_banner') ? 1 : 0,
            'manage_imageevent' => $request->has('manage_imageevent') ? 1 : 0,
            'manage_formevent' => $request->has('manage_formevent') ? 1 : 0,
            'form_event' => $request->has('form_event') ? 1 : 0,
            'view_customer' => $request->has('view_customer') ? 1 : 0,
        ];
        $user->permission = $permissions;

        // บันทึกข้อมูล
        $user->save();

        return redirect()->route('users.list')->with('success', 'อัปเดตผู้ใช้สำเร็จ!');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
    
        // ตรวจสอบการอัปโหลดรูปภาพใหม่
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageName = 'profile_' . $user->id . '.' . $image->getClientOriginalExtension();
    
            // ลบรูปเดิมออกจาก storage ถ้ามี
            if ($user->profile_image && Storage::exists(str_replace('storage/', 'public/', $user->profile_image))) {
                Storage::delete(str_replace('storage/', 'public/', $user->profile_image));
            }
    
            // บันทึกไฟล์ใหม่ลง storage
            $path = $image->storeAs('public/profile_images', $imageName);
            $user->profile_image = str_replace('public/', 'storage/', $path);
        } 
    
        // ตรวจสอบว่ามีการกรอกรหัสผ่านใหม่หรือไม่
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        // อัปเดตข้อมูลผู้ใช้ (ยกเว้น profile_image และ password ที่ตรวจสอบแล้ว)
        $user->update($request->except(['profile_image', 'password']));
    
        // คืนค่าผลลัพธ์
        return redirect()->route('profile')->with('success', 'อัปเดตโปรไฟล์เรียบร้อย!');
    }
    

    



    public function search(Request $request)
    {
        $query = $request->input('query');
        // เปลี่ยนจาก get() เป็น paginate()
        $users = User::where('username', 'LIKE', "%{$query}%")
            ->paginate(10);  // ใช้การแบ่งหน้าเหมือนกับเมธอด listUsers

        return view('users.listusers', compact('users'));
    }
    public function updateProfileImage(Request $request)
    {
        $validatedData = $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = auth()->user();

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $imageData = base64_encode(file_get_contents($image));
            $imageSrc = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . $imageData;

            $user->profile_image = $imageSrc;
            $user->save();
        }

        return redirect()->back()->with('success', 'อัปเดตรูปโปรไฟล์สำเร็จ!');
    }
    public function showProfile()
    {
        $user = auth()->user(); // หรือ $user = User::find($id); หากต้องการดึงข้อมูลของผู้ใช้คนอื่น

        // ดึงชื่อจังหวัด
        $provinceName = $user->province ? $user->province->province_name : 'ยังไม่มีข้อมูล';

        // ดึงชื่อศูนย์บริการ
        $centerName = $user->serviceCenter ? $user->serviceCenter->center_name : 'ยังไม่มีข้อมูล';

        // ส่งข้อมูลไปยัง view
        return view('profile', compact('user', 'provinceName', 'centerName'));
    }


    public function getProvinces()
    {
        $provinces = ProvinceActivity::all();
        return view('users.insertusers', compact('provinces'));
    }

    public function getCentersUser(Request $request)
    {
        $provinceId = $request->input('province_id');

        // Validate province_id
        if (!$provinceId) {
            return response()->json(['error' => 'Province ID is missing'], 400);
        }

        // Fetch centers based on province_id
        $centers = ServiceCenterActivity::where('province_id', $provinceId)->get();

        // Return an error if no centers found
        if ($centers->isEmpty()) {
            return response()->json(['error' => 'No centers found for this province'], 404);
        }

        return response()->json($centers);
    }



    public function create()
    {
        $provinces = ProvinceActivity::all(); // ดึงข้อมูลจังหวัดทั้งหมด
        return view('users.insertusers', compact('provinces'));
    }


    public function getCenters($province_id)
    {
        $centers = ServiceCenterActivity::where('province_id', $province_id)->get();
        return response()->json($centers);
    }


    public function getCentersByProvince(Request $request)
{
    $provinceId = $request->input('province_id');
    $centers = ServiceCenterActivity::where('province_id', $provinceId)->get();
    return response()->json($centers);
}


    

}
