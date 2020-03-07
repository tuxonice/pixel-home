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
     * Can push FLOOD sensor data without flood
     *
     * @return void
     */
    public function testCanPushFloodEventsWithoutFlood()
    {
        factory(Sensor::class)->states('flood')->create();

        $response = $this->get('/event/push/12345?sensor=FL01&temp=17.62&flood=0&batV=2.98');
        $response->assertStatus(200);
    }
    
    /**
     * Can push FLOOD sensor data with flood
     *
     * @return void
     */
    public function testCanPushFloodEventsWithFlood()
    {
        factory(Sensor::class)->states('flood')->create();

        $response = $this->get('/event/push/12345?sensor=FL01&temp=17.62&flood=1&batV=2.98');
        $response->assertStatus(200);
        
        $emails = app()->make('swift.transport')->driver()->messages();
        $this->assertCount(1, $emails);
    }
    
    /**
     * Can push sensor data to aternative route
     *
     * @return void
     */
    public function testCanPushEventsToAlternativeRoute()
    {
        factory(Sensor::class)->create();

        $response = $this->get('/sensor/push/12345?sensor=HT01&hum=79&temp=17.00');
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





