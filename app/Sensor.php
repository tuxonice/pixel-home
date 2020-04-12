<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensors extends Model
{
    public $timestamps = false;
    
    public function sensorType()
    {
        return $this->belongsTo('App\SensorType');
    }
}
