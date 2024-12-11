<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{

    public function listUsers()
    {
        // ดึงข้อมูลทั้งหมดจากตาราง users
        $users = User::all();

        // ส่งข้อมูลไปยัง View
        return view('users.listusers', compact('users'));
    }

    function delete($id){
        DB::table('users')->where('id',$id)->delete();
        return redirect('/listusers');
    }

    public function store(Request $request)
{
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:6', // เพิ่มการตรวจสอบ password
        'employee_id' => 'required|string|unique:users,employee_id',
    ]);

    $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']), // บังคับใส่ password
        'employee_id' => $validatedData['employee_id'],
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'employee_id' => 'required|string|unique:users,employee_id,' . $id,
        ]);

        $user = User::findOrFail($id);
        
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->employee_id = $validatedData['employee_id'];
        
        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
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
        $query = $request->input('query'); // รับค่าคำค้นจากแบบฟอร์ม
        $users = User::where('name', 'LIKE', "%{$query}%")->get(); // ค้นหาจากชื่อผู้ใช้ที่ตรงกับคำค้น
    
        return view('users.listusers', compact('users')); // ส่งผลลัพธ์ไปยัง View
    }
    
    
    
}




