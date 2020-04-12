<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SensorType extends Model
{
    public $timestamps = false;
    
    public function sensors()
    {
        return $this->hasMany('App\Sensor');
    }
}
