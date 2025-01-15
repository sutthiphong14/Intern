<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeedActivity extends Model
{
    use HasFactory;
    protected $table = 'speed_activity';
    protected $fillable = ['speed_name', 'promotion_id', 'service_id'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล
    public function promotionActivities()
    {
        return $this->hasMany(PromotionActivity::class, 'promotion_id', 'promotion_id');
    }

    public function serveActivity()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id', 'service_id');
    }
}


