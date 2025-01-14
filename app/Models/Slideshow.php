<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    // กำหนดชื่อของตารางในฐานข้อมูล
    protected $table = 'slideshows';

    // กำหนดชื่อ primary key
    protected $primaryKey = 'slideshow_id';

    // กำหนดคอลัมน์ที่สามารถทำการ mass assignment ได้
    protected $fillable = [
        'slideshow_image',
        'slideshow_link',

    ];

    

    // หากต้องการให้ใช้ timestamps (created_at, updated_at)
    public $timestamps = true;  // ถ้าต้องการ
    // public $timestamps = false; // ถ้าไม่ต้องการให้ Laravel จัดการ timestamps
}
