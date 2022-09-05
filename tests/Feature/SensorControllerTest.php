<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SensorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User Can View Sensor List.
     *
     * @return void
     */
    public function testUserCanViewSensorList()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);

        $response = $this->get('/sensor/list');

        $response->assertStatus(200);
        $response->assertSeeText('Sensors');
    }

    public function testUserCanViewNewSensorForm()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response = $this->get('/sensor/create');

        $response->assertStatus(200);
        $response->assertViewIs('partials.sensor.create');
    }
}
