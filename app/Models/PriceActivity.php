<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceActivity extends Model
{
    use HasFactory;
    protected $table = 'price_activity';
    protected $fillable = ['price_name', 'promotion_id', 'service_id', 'speed_id'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล

    public function promotionActivities()
    {
        return $this->hasMany(PromotionActivity::class, 'promotion_id', 'promotion_id');
    }

    public function serveActivity()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id', 'service_id');
    }

    public function speedActivity()
    {
        return $this->belongsTo(SpeedActivity::class, 'speed_id', 'speed_id');
    }
}
