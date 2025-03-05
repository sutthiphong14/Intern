<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IctSolution extends Model
{
    use HasFactory;
    protected $table = 'ict_solution';
    protected $primaryKey = 'ict_id'; // กำหนด primary key

    protected $fillable = ['customer_type','quote','income','cus_id','type_id','ict_service_id','province_id','center_id'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    public function customer()
    {
        return $this->hasMany(Customer::class, 'cus_id', 'cus_id');
    }
    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id', 'province_id');
    }
    public function center()
    {
        return $this->belongsTo(ServiceCenterActivity::class, 'center_id', 'center_id');
    }


    // เชื่อมความสัมพันธ์ Many-to-Many
    public function products()
    {
        return $this->belongsToMany(IctProduct::class, 'ict_solution_products', 'ict_id', 'product_id')
                    ->withPivot('quantity','price')
                    ->withTimestamps();
    }

    
    

}
