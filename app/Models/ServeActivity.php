<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PromotionActivity;

class ServeActivity extends Model
{
    protected $table = 'serve_activity';
    protected $primaryKey = 'service_id';
    protected $fillable = ['service_name', 'promotion_id'];
    
    public function promotion()
    {
        return $this->belongsTo(PromotionActivity::class, 'promotion_id', 'promotion_id');
    }
}