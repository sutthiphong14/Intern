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
        $userPermissions = Auth::user()->permission;

        // ถ้าเป็น String (JSON) ให้แปลงเป็น Array
        if (is_string($userPermissions)) {
            $userPermissions = json_decode($userPermissions, true) ?? [];
        }

        // ตรวจสอบสิทธิ์
        foreach ($permissions as $permission) {
            if (!empty($userPermissions[$permission])) {
                return $next($request); // มีสิทธิ์ เข้าได้
            }
        }

        // ถ้าไม่มีสิทธิ์ ให้ redirect ไปหน้า home พร้อมแจ้งเตือน
        return redirect('/home')->with('error', 'คุณไม่มีสิทธิ์เข้าถึง Function นี้');
        
    }
}
