<?php

namespace Tests\Feature;

use App\Sensor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventPushTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCanPushEvents()
    {

        factory(Sensor::class)->create();

        $response = $this->get('/event/push/12345?sensor=HT01&hum=79&temp=17.00');
        $response->assertStatus(200);
    }
}





