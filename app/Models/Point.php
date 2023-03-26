<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    public $timestamps = false;

    protected $casts = [
        'added_on' => 'immutable_datetime',
    ];

    public function sensor()
    {
        return $this->belongsTo('App\Models\Sensor');
    }

    public function device()
    {
        return $this->belongsTo('App\Models\Device');
    }
}
