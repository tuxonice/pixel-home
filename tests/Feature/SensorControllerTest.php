<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorControllerTest extends TestCase
{

     use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function testUserCanViewSensorList(): void
    {
        $response = $this->get('/sensor/list');

        $response->assertStatus(200);
        $response->assertSeeText('Sensors');
    }

    public function testUserCanViewNewSensorForm(): void
    {
        $response = $this->get('/sensor/create');
        $response->assertStatus(200);
        $response->assertViewIs('sensors.create');
    }

    public function testUserCanCreateNewSensor(): void
    {
        $response = $this->post('/sensor', [
            'name' => 'Test sensor',
            'unit' => '%',
            'unit_symbol' => '%',
            'active' => true,
        ]);
        $response->assertRedirect('/sensor/list');

        $response = $this->get('/sensor/list');
        $response->assertStatus(200);
        $response->assertSeeText('Test sensor');
    }

}
