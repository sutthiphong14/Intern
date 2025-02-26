<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserPermissions
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        // ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'กรุณาล็อกอินก่อน');
        }

        // ดึงข้อมูล permission ของผู้ใช้
        $userPermissions = Auth::user()->permission ?? [];

        // ตรวจสอบว่ามีสิทธิ์อย่างน้อย 1 อย่างจากที่กำหนดหรือไม่
        foreach ($permissions as $permission) {
            if (!empty($userPermissions[$permission])) {
                return $next($request); // มีสิทธิ์ เข้าได้
            }
        }

        // ถ้าไม่มีสิทธิ์เลย ให้ redirect กลับไปหน้า home
        return redirect('/home')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
    }
}
