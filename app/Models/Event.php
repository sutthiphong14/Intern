<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events'; // กำหนดชื่อตาราง
    protected $primaryKey = 'event_id'; // ระบุ Primary Key ให้ตรงกับ Database
    public $incrementing = true; // ใช้ Auto Increment
    protected $keyType = 'int'; // กำหนดชนิดข้อมูล Primary Key
    protected $fillable = ['nameevent']; // อนุญาตให้เพิ่มข้อมูล nameevent
}
