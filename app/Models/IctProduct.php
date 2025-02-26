<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IctProduct extends Model
{
    use HasFactory;
    protected $table = 'ict_products';
    protected $primaryKey = 'product_id'; // กำหนด primary key

    protected $fillable = [
        'product_id',
        'product_name',
        'description',
        'type_id'

    ];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    // เชื่อมความสัมพันธ์ Many-to-Many
    public function ictSolutions()
    {
        return $this->belongsToMany(IctSolution::class, 'ict_solution_products', 'product_id', 'ict_id')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function typeActivities()
    {
        return $this->hasMany(TypeActivity::class, 'type_id', 'type_id');
    }
}
