<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IctService extends Model
{
    use HasFactory;

    protected $table = 'ict_services';
    protected $primaryKey = 'ict_service_id';

    protected $fillable = [
        'service_name',
        'description',
        'service_id',
        'type_id'
    ];

    
  
}