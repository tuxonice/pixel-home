<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    public function sensors()
    {
        return $this->belongsToMany('App\Models\Sensor');
    }

    public function points()
    {
        return $this->hasMany('App\Models\Point');
    }
}
