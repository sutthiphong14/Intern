<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasFactory;

    protected $table = 'top_up';
    protected $fillable = ['phone', 'amount','type_id','province_id','center_id'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id');
    }
    public function center()
    {
        return $this->belongsTo(ServiceCenterActivity::class, 'center_id', 'center_id');  // เพิ่มความสัมพันธ์กับ Center
    }
}


