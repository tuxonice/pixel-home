<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    /**
     * Get the sensor record associated with the alert.
     */
    public function sensor()
    {
       return $this->belongsTo('App\Sensor');
    }
}
