<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    /**
     * Get the event that owns the sensor.
     */
    public function event()
    {
        return $this->hasMany('App\Event');
    }
    
    /**
     * Get the event that owns the sensor.
     */
    public function alert()
    {
        return $this->hasMany('App\Alert');
    }
}
