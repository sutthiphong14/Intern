<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionActivity extends Model
{
    use HasFactory;
    protected $table = 'promotion_activity';
    protected $fillable = ['promotion_name', 'service_id'];
    public $timestamps = true;  // ใช้เวลาในการอัปเดต/สร้างข้อมูล


    public function serveActivity()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id', 'service_id');
    }
}
