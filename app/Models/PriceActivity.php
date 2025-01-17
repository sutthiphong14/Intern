<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceActivity extends Model
{
    use HasFactory;
    protected $table = 'price_activity';
    protected $fillable = ['price_name', 'speed_id'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล
    public function speedActivity()
    {
        return $this->belongsTo(SpeedActivity::class, 'speed_id', 'speed_id');
    }
}


