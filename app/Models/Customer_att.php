<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_att extends Model
{
    use HasFactory;
    protected $table = 'customer_attributes';
    protected $fillable = ['customer_id','attribute_id','value'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    public function service()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id', 'service_id');
    }
    public function attribute()
    {
        return $this->belongsTo(Service_att::class, 'attribute_id', 'attribute_id');
    }
}