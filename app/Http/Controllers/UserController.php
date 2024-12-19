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

    function delete($id){
        DB::table('users')->where('id',$id)->delete();
        return redirect('/listusers');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            //'employee_id' => 'required|string|unique:users,employee_id',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // เพิ่มการตรวจสอบไฟล์
        ]);

        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            // อัพโหลดไฟล์และบันทึกพาธ
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user = User::create([
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            //'employee_id' => $validatedData['employee_id'],
            'profile_image' => $imagePath, // บันทึกพาธของรูปภาพ
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            //'employee_id' => 'required|string|unique:users,employee_id,' . $id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::findOrFail($id);
        
        $user->username = $validatedData['username'];
        $user->email = $validatedData['email'];
        //$user->employee_id = $validatedData['employee_id'];
        
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        if ($request->hasFile('profile_image')) {
            // ลบรูปเก่าก่อนอัพโหลดใหม่
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            
            // อัพโหลดรูปใหม่
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->permission = json_encode([
            'manage_users' => $request->has('manage_users_permission') ? 1 : 0,
            'manage_dashboard' => $request->has('manage_dashboard_permission') ? 1 : 0,
            'manage_newsfeed' => $request->has('manage_newsfeed_permission') ? 1 : 0,
        ]);

        $user->save();

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

    $user = auth()->user(); // ดึงผู้ใช้ปัจจุบัน

    // ลบรูปเก่าก่อนอัพโหลดใหม่
    if ($user->profile_image) {
        Storage::disk('public')->delete($user->profile_image);
    }
    
    // อัพโหลดรูปใหม่
    $imagePath = $request->file('profile_image')->store('profile_images', 'public');
    $user->profile_image = $imagePath;
    $user->save();

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