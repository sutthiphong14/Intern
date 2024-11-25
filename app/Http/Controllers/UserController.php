<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // ใช้ Model User

class UserController extends Controller
{
    public function index()
    {
        // ดึงข้อมูลจากตาราง users
        $users = User::all(); // หรือสามารถใช้ paginate() ได้

        // ส่งข้อมูลไปที่ View
        return view('tableusers', compact('users'));
    }
}


