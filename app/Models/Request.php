<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $primaryKey = 'id_request';

    protected $fillable = [
        'id_employee',
        'user_request',
        'name_request',
        'email_request',
        'phone_request',
        'description_request',
        'password_request'
    ];
}