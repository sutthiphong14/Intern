<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivity extends Model
{
    use HasFactory;

    protected $table = 'user_activity';
    protected $primaryKey = 'id_card';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'id_card', 'full_name', 'photo', 'address_no', 'road', 'soi',
        'sub_district', 'district', 'postal_code', 'type_id', 'province_id'
    ];

    public function type()
    {
        return $this->belongsTo(TypeActivity::class, 'type_id');
    }

    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id');
    }
}
