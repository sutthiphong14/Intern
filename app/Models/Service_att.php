<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service_att extends Model
{
    use HasFactory;
    protected $table = 'service_attributes';
    protected $fillable = ['attribute_name','data_type','is_required', 'service_id','custom_true_value', 'custom_false_value'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    public function service()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id', 'service_id');
    }
    public function customerAttributes()
    {
        return $this->hasMany(Customer_att::class, 'attribute_id', 'attribute_id');
    }
}
