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
        'username' => 'required|string',
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
        $user = User::findOrFail($id);
        return view('users.editusers', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'emp_id' => 'required|string|max:255', // Ensure emp_id is included
            'department' => 'required|string|max:255',

        ]);

        // ค้นหาผู้ใช้ที่ต้องการอัปเดต
        $user = User::findOrFail($id);

        // อัปเดตข้อมูลที่ไม่เกี่ยวข้องกับรูปภาพ
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];
        $user->emp_id = $validatedData['emp_id'];
        $user->department = $validatedData['department'];

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        // การอัปเดตรูปภาพ
        if ($request->hasFile('profile_image')) {
            // ลบรูปเก่าก่อน
            if ($user->profile_image) {
                // ลบข้อมูล Base64 ของรูปเก่า
                $user->profile_image = null;
            }

            // แปลงรูปภาพเป็น Base64
            $image = $request->file('profile_image');
            $imageData = base64_encode(file_get_contents($image));
            $imageSrc = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . $imageData;

            // บันทึกรูป Base64 ลงในฐานข้อมูล
            $user->profile_image = $imageSrc;
        }

        // อัปเดตสิทธิ์การใช้งาน
        $user->permission = json_encode([
            'manage_users' => $request->has('manage_users_permission') ? 1 : 0,
            'manage_dashboard' => $request->has('manage_dashboard_permission') ? 1 : 0,
            'manage_newsfeed' => $request->has('manage_newsfeed_permission') ? 1 : 0,
        ]);

        // บันทึกข้อมูลที่อัปเดต
        $user->save();

        // ส่งกลับไปยังหน้าเดิมพร้อมข้อความสำเร็จ
        return redirect()->route('users.list')->with('success', 'อัปเดตผู้ใช้สำเร็จ!');
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
        $user = auth()->user(); // Dapatkan pengguna yang saat ini login

        if (!$user) {
            return redirect()->route('login'); // Redirect ke halaman login jika tidak ada pengguna login
        }

        return view('profile', compact('user'));
    }


    public function getProvinces()
    {
        $provinces = ProvinceActivity::all();
        return view('eusers.insertusers', compact('provinces'));
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
        $centers = ServiceCenterActivity::where('province_id', $request->province_id)->get(['center_id', 'center_name']);
        return response()->json($centers);
    }





}
