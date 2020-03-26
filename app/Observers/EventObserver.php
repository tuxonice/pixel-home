<?php

namespace App\Observers;

use App\Event;
use Illuminate\Support\Facades\DB;

class EventObserver
{
    /**
     * Handle the event "saving" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function saving(Event $event)
    {
        $lastEvent = DB::table('events')->join('sensors', 'events.sensor_id', '=', 'sensors.id')
            ->where('events.sensor_id', $event->sensor_id)
            ->select('events.*', 'sensors.type')
            ->orderBy('events.added_on', 'desc')
            ->first();       
               
        if(is_null($lastEvent)) {
            return;
        }

        if ($lastEvent->type === 'HT') {
            $event->diff_temperature = $event->temperature - $lastEvent->temperature;
            $event->diff_humidity = $event->humidity - $lastEvent->humidity;
            $event->diff_time = 0;
        }

        if ($lastEvent->type === 'FLOOD') {
            $event->diff_temperature = $event->temperature - $lastEvent->temperature;
            $event->diff_time = 0;
        }

    }

}
