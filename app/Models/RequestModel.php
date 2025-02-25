<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    protected $table = 'requests'; // ระบุชื่อตารางให้แน่ชัด
    protected $primaryKey = 'id_request';
    public $timestamps = true;

    protected $fillable = [
        'id_employee_request',
        'user_request',
        'password_request',
        'name_request',
        'email_request',
        'department_request',
        'description_request',
        'province_id',
        'center_id',
    ];

    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id', 'province_id');
    }

    public function serviceCenter()
    {
        return $this->belongsTo(ServiceCenterActivity::class, 'center_id', 'center_id');
    }
}
