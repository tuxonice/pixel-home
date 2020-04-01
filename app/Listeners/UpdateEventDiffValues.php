<?php

namespace App\Listeners;

use App\Events\EventSaving;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateEventDiffValues
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EventSaving  $eventSaving
     * @return void
     */
    public function handle(EventSaving $eventSaving)
    {
        $lastEvent = DB::table('events')->join('sensors', 'events.sensor_id', '=', 'sensors.id')
            ->where('events.sensor_id', $eventSaving->event->sensor_id)
            ->select('events.*', 'sensors.type')
            ->orderBy('events.added_on', 'desc')
            ->first();       

        if(is_null($lastEvent)) {
            return;
        }

        $eventSaving->event->diff_time = Carbon::parse($eventSaving->event->added_on)->diffInMinutes($lastEvent->added_on);
        $eventSaving->event->diff_temperature = $eventSaving->event->temperature - $lastEvent->temperature;

        if ($lastEvent->type === 'HT') {
            $eventSaving->event->diff_humidity = $eventSaving->event->humidity - $lastEvent->humidity;
        }
    }
}
