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
        'action' => 'created',
        'model' => 'User',
        'data' => json_encode($user->toArray()),
    ]);
}

    public function updated(User $user)
    {
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'model' => 'User',
            'data' => json_encode($user->getChanges()),
        ]);
    }

    public function deleted(User $user)
    {
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'model' => 'User',
            'data' => json_encode($user->toArray()),
        ]);
    }
}
