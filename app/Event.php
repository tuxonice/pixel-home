<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the sensor record associated with the event.
     */
    public function sensor()
    {
       return $this->belongsTo('App\Sensor');
    }
}
