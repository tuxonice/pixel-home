<?php

namespace App\Mail;

use App\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventAlert extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The event instance.
     *
     * @var Event
     */
    public $event;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.event.alert')
            ->with([
                'sensorName' => $this->event->sensor()->first()->name,
                'location' => $this->event->location,
                'temperature' => $this->event->temperature,
                'timestamp' => $this->event->added_on,
            ]
            );
    }
}
