<?php

namespace App\Observers;

use App\Event;

class EventObserver
{
    /**
     * Handle the event "created" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function created(Event $event)
    {
        $event->diff_temperature = 1.5;

        $event->save();
    }

    /**
     * Handle the event "updated" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function updated(Event $event)
    {
        //
    }

    /**
     * Handle the event "deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function deleted(Event $event)
    {
        //
    }

    /**
     * Handle the event "restored" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function restored(Event $event)
    {
        //
    }

    /**
     * Handle the event "force deleted" event.
     *
     * @param  \App\Event  $event
     * @return void
     */
    public function forceDeleted(Event $event)
    {
        //
    }
}
