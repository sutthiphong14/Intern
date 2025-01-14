<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceActivity extends Model
{
    use HasFactory;

    // กำหนดชื่อของตารางถ้าไม่ตรงกับชื่อ Model
    protected $table = 'price_activity';

    // กำหนดฟิลด์ที่สามารถกรอกข้อมูลได้ (Mass Assignable)
    protected $fillable = [
        'price_name',
    ];

    // กำหนดคีย์หลัก (Primary Key) ถ้าใช้คีย์หลักเป็นชื่อที่ไม่ตรงกับ default 'id'
    protected $primaryKey = 'price_id';

    // กำหนดประเภทของคีย์หลัก ถ้าไม่ใช้ 'int'
    protected $keyType = 'int';

    // ถ้าตารางไม่ใช้ `timestamps`
    public $timestamps = true;
}