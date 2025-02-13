<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = ['name', 'username', 'emp_id', 'department', 'email', 'password', 'permission', 'profile_image', 'province_id', 'center_id'];

    protected $hidden = ['password', 'remember_token'];

    public function province(): BelongsTo
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id');
    }

    public function serviceCenter(): BelongsTo
    {
        return $this->belongsTo(ServiceCenterActivity::class, 'center_id');
    }
}
