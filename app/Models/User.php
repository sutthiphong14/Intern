<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ใช้ Authenticatable แทน Model
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory;

    // หากชื่อของตารางไม่ใช่ 'users' ให้กำหนดชื่อของตารางที่นี่
    protected $table = 'users';

    // กำหนดฟิลด์ที่อนุญาตให้ทำการ fill
    protected $fillable = ['name', 'email', 'password', 'permission','employee_id','profile_image'];

    // Optional: Add a mutator to handle permission JSON
public function setPermissionAttribute($value)
{
    $this->attributes['permission'] = is_array($value) ? json_encode($value) : $value;
}

public function getPermissionAttribute($value)
{
    return json_decode($value, true);
}
// Remove email from fillable fields
protected $hidden = ['password', 'remember_token'];

// Mutator for permission




// Override the method to use employee_id for authentication
public function findForPassport($employee_id)
{
    return $this->where('employee_id', $employee_id)->first();
}



}
