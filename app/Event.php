<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\EventSaving;

/**
 * App\Event
 *
 * @property int $id
 * @property int|null $sensor_id
 * @property float|null $temperature
 * @property float $diff_temperature
 * @property float|null $humidity
 * @property float $diff_humidity
 * @property int|null $flood
 * @property float|null $battery
 * @property string|null $location
 * @property string $added_on
 * @property int $diff_time
 * @property-read \App\Sensor|null $sensor
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereAddedOn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereBattery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDiffHumidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDiffTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereDiffTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereFlood($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereHumidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereSensorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Event whereTemperature($value)
 * @mixin \Eloquent
 */
class Event extends Model
{
    
    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'saving' => EventSaving::class,
    ];
    
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
