<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceActivity extends Model
{
    use HasFactory;

    protected $table = 'province_activity';
    protected $primaryKey = 'province_id';
    protected $fillable = ['province_name']; // ลบ center_id ออก

    public function centers()
    {
        return $this->hasMany(ServiceCenterActivity::class, 'province_id');
    }
}
