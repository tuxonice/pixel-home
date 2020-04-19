<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPoint extends Model
{
    public function sensor()
    {
        return $this->belongsTo('App\Sensor');
    }
}
