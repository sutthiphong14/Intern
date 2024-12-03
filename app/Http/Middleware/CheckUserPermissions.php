<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPermissions
{
    public function handle(Request $request, Closure $next, $permission)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'กรุณาล็อกอินก่อน');
        }

        // Get user permissions
        $userPermissions = Auth::user()->permission;

        // Check specific permission
        if (!$userPermissions || !($userPermissions[$permission] ?? false)) {
            // Redirect or show error if no permission
            return redirect('/home')->with('error', 'คุณไม่มีสิทธิ์เข้าถึงหน้านี้');
        }

        return $next($request);
    }
}