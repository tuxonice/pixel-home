<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Alert
 *
 * @property int $id
 * @property int $sensor_id
 * @property string|null $alert_on
 * @property string|null $reset_on
 * @property-read \App\Sensor $sensor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereAlertOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereResetOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Alert whereSensorId($value)
 * @mixin \Eloquent
 */
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
