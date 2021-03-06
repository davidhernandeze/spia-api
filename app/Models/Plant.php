<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    public $timestamps = false;
    protected $fillable = ['humidity', 'max_humidity', 'device_id'];

    public function device()
    {
        return $this->belongsTo('App\Models\Device', 'device_id');
    }
}
