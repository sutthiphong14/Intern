<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeActivity extends Model
{
    use HasFactory;

    protected $table = 'type_activity';
    protected $primaryKey = 'type_id';
    protected $fillable = ['service_id','type_name'];

    public function service()
    {
        return $this->belongsTo(ServeActivity::class, 'service_id');
    }

    public function users()
    {
        return $this->hasMany(UserActivity::class, 'type_id');
    }
}
