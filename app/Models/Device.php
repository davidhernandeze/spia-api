<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $timestamps = false;
    protected $fillable = ['automatic_mode', 'hours_to_repeat',
        'temperature', 'next_irrigation', 'last_irrigation',
        'watering_seconds', 'last_setting_change'];
}
