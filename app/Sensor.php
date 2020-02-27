<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sensor extends Model
{
    use SoftDeletes;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    
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
