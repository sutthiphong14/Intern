<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinceActivity extends Model
{
    use HasFactory;

    protected $table = 'province_activity';
    protected $primaryKey = 'province_id';
    protected $fillable = ['province_name', 'center_id'];

    public function center()
    {
        return $this->belongsTo(ServiceCenterActivity::class, 'center_id');
    }

    public function users()
    {
        return $this->hasMany(UserActivity::class, 'province_id');
    }
}
