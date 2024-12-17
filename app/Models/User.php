<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = ['name', 'username', 'email', 'password', 'permission', 'employee_id', 'profile_image'];

    protected $hidden = ['password', 'remember_token'];

    public function setPermissionAttribute($value)
    {
        $this->attributes['permission'] = is_array($value) ? json_encode($value) : $value;
    }

    public function getPermissionAttribute($value)
    {
        return json_decode($value, true);
    }

    // Override the method to use username for authentication
    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}