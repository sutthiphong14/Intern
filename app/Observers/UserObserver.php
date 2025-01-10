<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserLog; // โมเดล Log ที่เราสร้าง
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user)
    {

        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'เพิ่มผู้ใช้งาน',
            'model' => 'จัดการผู้ใช้งาน',
            'data' => json_encode([
                'username' => $user->username,
                'message' => 'เพิ่มผู้ใช้' 

            ]), 
        ]);
    }

    public function updated(User $user)
{
    UserLog::create([
        'user_id' => Auth::id(),
        'action' => 'แก้ไขผู้ใช้งาน',
        'model' => 'จัดการผู้ใช้งาน',
        'data' => json_encode([
            'username' => $user->username,
            'message' => 'แก้ไขผู้ใช้งาน'
        ]),
    ]);
}


public function deleted(User $user)
{
    UserLog::create([
        'user_id' => Auth::id(),
        'action' => 'ลบผู้ใช้งาน',
        'model' => 'จัดการผู้ใช้งาน',
        'data' => json_encode([
            'username' => $user->username,
            'message' => 'ลบผู้ใช้งาน'
        ]),
    ]);
}

}
