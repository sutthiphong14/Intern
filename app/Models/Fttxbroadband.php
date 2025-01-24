<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fttxbroadband extends Model
{
    use HasFactory;
    protected $table = 'fttx_broadband';
    protected $fillable = ['new','installation_type','cus_id','province_id','center_id'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    public function customer()
    {
        return $this->hasMany(Customer::class, 'cus_id', 'cus_id');
    }
    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id', 'province_id');
    }
}