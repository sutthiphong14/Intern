<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionActivity extends Model
{
    use HasFactory;

    protected $table = 'promotion_activity';
    protected $primaryKey = 'promotion_id';
    protected $fillable = ['promotion_name', 'speed_id'];

    public function speed()
    {
        return $this->belongsTo(SpeedActivity::class, 'speed_id');
    }

    public function services()
    {
        return $this->hasMany(ServeActivity::class, 'promotion_id');
    }
}
