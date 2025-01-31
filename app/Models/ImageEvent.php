<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageEvent extends Model
{
    use HasFactory;

    protected $table = 'image_events';
    protected $primaryKey = 'image_id';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['event_id', 'image_event'];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id'); // อ้างอิง event_id ทั้งสองด้าน
    }
}


