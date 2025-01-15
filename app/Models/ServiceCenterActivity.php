<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCenterActivity extends Model
{
    use HasFactory;

    protected $table = 'serviceCenter_activity';
    protected $primaryKey = 'center_id';
    protected $fillable = ['center_name', 'province_id'];

    public function province()
    {
        return $this->belongsTo(ProvinceActivity::class, 'province_id');
    }
}
