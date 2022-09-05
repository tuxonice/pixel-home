<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    public $timestamps = false;

    public function devices()
    {
        return $this->belongsToMany('App\Models\Device');
    }

    public function points()
    {
        return $this->hasMany('App\Models\Point');
    }
}
