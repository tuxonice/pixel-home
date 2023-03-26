<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * User Can View Sensor List.
     *
     * @return void
     */
    public function testUserCanViewDeviceList()
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

        $response = $this->get('/device/list');

        $response->assertStatus(200);
        $response->assertSeeText('Devices');
    }

    public function testUserCanViewNewDeviceForm()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response = $this->get('/device/create');

        $response->assertStatus(200);
        $response->assertViewIs('partials.device.create');
    }

    public function testUserCanCreateNewDevice()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response = $this->get('/device/create');

        $response->assertStatus(200);
        $response->assertViewIs('partials.device.create');

        $response = $this->post('/device', [
            'name' => 'test-sensor',
            'location' => 'test-location',
            'code' => '12345',
            'sensor_id' => '1',
            'active' => 1,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('device/list');
    }
}
