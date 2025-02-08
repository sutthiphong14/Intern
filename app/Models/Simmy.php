<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simmy extends Model
{
    use HasFactory;

    protected $table = 'sim_my';
    protected $fillable = ['cus_new', 'service_id','price_id','cus_id','center_id','province_id','created_at'];

    public function service()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id', 'service_id');  // เพิ่มความสัมพันธ์กับ promotion
    }
    public function price()
    {
        return $this->belongsTo(PriceActivity::class, 'price_id', 'price_id');  // เพิ่มความสัมพันธ์กับ Price
    }
    public function customer()
    {
        return $this->hasMany(Customer::class, 'cus_id', 'cus_id');
    }

    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id');
    }
}
