<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // ชื่อตารางในฐานข้อมูล
    protected $table = 'customers';


    // คอลัมน์ที่อนุญาตให้เพิ่มหรือแก้ไขข้อมูล
    protected $fillable = [
        'cus_id',
        'cus_fullname',
        'id_card',
        'cus_photo',
        'cus_address',
        'type_id',
        'service_id',
        'promotion_id',
        'speed_id',
        'price_id',
        'province_id',
        'center_id',
        'created_at',
        'other'

    ];

    // ความสัมพันธ์กับ Model อื่น ๆ
    public function type()
    {
        return $this->belongsTo(TypeActivity::class, 'type_id', 'type_id');
    }

    public function service()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id', 'service_id');
    }

    public function promotion()
    {
        return $this->belongsTo(PromotionActivity::class, 'promotion_id', 'promotion_id');  // เพิ่มความสัมพันธ์กับ promotion
    }

    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id', 'province_id');
    }

    public function speed()
    {
        return $this->belongsTo(SpeedActivity::class, 'speed_id', 'speed_id');  // เพิ่มความสัมพันธ์กับ Speed
    }

    public function price()
    {
        return $this->belongsTo(PriceActivity::class, 'price_id', 'price_id');  // เพิ่มความสัมพันธ์กับ Price
    }

    public function center()
    {
        return $this->belongsTo(ServiceCenterActivity::class, 'center_id', 'center_id');  // เพิ่มความสัมพันธ์กับ Center
    }
}
