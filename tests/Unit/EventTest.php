<?php

namespace Tests\Unit;

use App\Event;
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase
{

    /** @var Event */
    protected $event;

    protected function setUp(): void
    {
        $this->event = new Event();
        $this->event->temperature = 19.5;
        $this->event->humidity = 65;
        $this->event->battery = 2.98;
    }

    /**
     * Set Event Temperature
     *
     * @return void
     */
    public function testCanSetAndGetSensorTemperature()
    {
        $this->assertEquals(19.5, $this->event->temperature);
    }

    /**
     * Set Event Humidity
     *
     * @return void
     */
    public function testCanSetAndGetSensorHumidity()
    {
        $this->assertEquals(65, $this->event->humidity);
    }

    /**
     * Set Event Humidity
     *
     * @return void
     */
    public function testCanSetAndGetSensorBatteryLevel()
    {
        $event = new Event();
        $event->battery = 2.98;

        $this->assertEquals(2.98, $this->event->battery);
    }

}
