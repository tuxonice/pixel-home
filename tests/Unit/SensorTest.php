<?php

namespace Tests\Unit;

use App\Models\Sensor;
use PHPUnit\Framework\TestCase;

class SensorTest extends TestCase
{

    /** @var Sensor */
    protected $sensor;

    protected function setUp(): void
    {
        $this->sensor = new Sensor();
        $this->sensor->name = 'Temperature';
        $this->sensor->unit = 'Celsius degree';
        $this->sensor->unit_symbol = 'ºC';
    }

    /**
     * Set Event Temperature
     *
     * @return void
     */
    public function testCanSetAndGetSensorName()
    {
        $this->assertEquals('Temperature', $this->sensor->name);
    }

    /**
     * Set Sensor Unit
     *
     * @return void
     */
    public function testCanSetAndGetSensorUnit()
    {
        $this->assertEquals('Celsius degree', $this->sensor->unit);
    }

}