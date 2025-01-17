<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServeActivity extends Model
{
    use HasFactory;
    protected $table = 'serve_activity';
    protected $fillable = ['service_name'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    public function promotionActivities()
    {
        return $this->hasMany(PromotionActivity::class, 'service_id', 'service_id');
    }
}
