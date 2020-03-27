<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Sensor
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $location
 * @property string $type
 * @property string|null $hash
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Alert[] $alert
 * @property-read int|null $alert_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Event[] $event
 * @property-read int|null $event_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Sensor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sensor whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sensor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Sensor withoutTrashed()
 * @mixin \Eloquent
 */
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
