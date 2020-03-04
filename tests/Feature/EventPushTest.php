<?php

namespace Tests\Feature;

use App\Sensor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventPushTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Can push sensor data
     *
     * @return void
     */
    public function testCanPushEvents()
    {
        factory(Sensor::class)->create();

        $response = $this->get('/event/push/12345?sensor=HT01&hum=79&temp=17.00');
        $response->assertStatus(200);
    }
    
    /**
     * Can't push sensor data if hash is wrong
     *
     * @return void
     */
    public function testCanNotPushEventsWithWrongHashCode()
    {
        factory(Sensor::class)->create();

        $response = $this->get('/event/push/abcd?sensor=HT01&hum=79&temp=17.00');
        $response->assertStatus(401);
    }
    
    /**
     * Can't push sensor data if sensor code does not exist
     *
     * @return void
     */
    public function testCanNotPushEventsWithWrongSensorCode()
    {
        factory(Sensor::class)->create();

        $response = $this->get('/event/push/12345?sensor=HT02&hum=79&temp=17.00');
        $response->assertStatus(401);
    }
}





