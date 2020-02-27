<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SensorAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $sensorName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($sensorName)
    {
        $this->sensorName = $sensorName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.event');
    }
}
