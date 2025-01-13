<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    protected $table = 'slideshows';

    protected $primaryKey = 'slideshow_id';

    protected $fillable = [
        'slideshow_image',
        'slideshow_link',
        'slideshow_status',
    ];
}

