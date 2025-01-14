<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpeedActivity extends Model
{
    use HasFactory;

    protected $table = 'speed_activity';
    protected $primaryKey = 'speed_id';
    protected $fillable = ['speed_name', 'price_id'];

    public function promotions()
    {
        return $this->hasMany(PromotionActivity::class, 'speed_id');
    }
}
