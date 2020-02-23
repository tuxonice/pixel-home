<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Get the sensor record associated with the event.
     */
    public function sensor()
    {
       return $this->belongsTo('App\Sensor');
    }
}
