<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    public $timestamps = false;
    
    public function sensorType()
    {
        return $this->belongsTo('App\SensorType');
    }

    public function device()
    {
        return $this->belongsTo('App\Device');
    }

    public function dataPoints()
    {
        return $this->hasMany('App\DataPoint');
    }
}
