<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function listUsers()
    {
        $users = User::all();
        return view('users.listusers', compact('users'));
    }

    function delete($id)
    {
        DB::table('users')->where('id', $id)->delete();
        return redirect('/listusers');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('profile_image')) {
            // แปลงรูปเป็น Base64
            $image = $request->file('profile_image');
            $imageData = base64_encode(file_get_contents($image));
            $imageSrc = 'data:image/' . $image->getClientOriginalExtension() . ';base64,' . $imageData;
        }

        $user = User::create([
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'profile_image' => $imageSrc ?? null,
            'permission' => json_encode([
                'manage_users' => $request->has('manage_users_permission') ? 1 : 0,
                'manage_dashboard' => $request->has('manage_dashboard_permission') ? 1 : 0,
                'manage_newsfeed' => $request->has('manage_newsfeed_permission') ? 1 : 0,
            ]),
        ]);

        return redirect()->back()->with('success', 'เพิ่มผู้ใช้สำเร็จ!');
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
            'email' => 'required|email|unique:users,email,' . $id,
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // ค้นหาผู้ใช้ที่ต้องการอัปเดต
        $user = User::findOrFail($id);

        // อัปเดตข้อมูลที่ไม่เกี่ยวข้องกับรูปภาพ
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        $user->name = $validatedData['name'];

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
        $users = User::where('username', 'LIKE', "%{$query}%")->get();

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
}
