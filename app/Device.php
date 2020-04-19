<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;

    public function sensors()
    {
        return $this->hasMany('App\Sensor');
    }
    
}
