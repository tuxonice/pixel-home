<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceControllerTest extends TestCase
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

    public function testUserCanViewDeviceList(): void
    {
        $response = $this->get('/device/list');

        $response->assertStatus(200);
        $response->assertSeeText('Devices');
    }

    public function testUserCanViewNewDeviceForm(): void
    {
        $response = $this->get('/device/create');

        $response->assertStatus(200);
        $response->assertViewIs('devices.create');
    }

    public function testUserCanCreateNewDevice(): void
    {
        $response = $this->post('/device', [
            'name' => 'Test device',
            'location' => 'test location',
            'code' => '1234',
            'active' => true,
        ]);
        $response->assertRedirect('/device/list');

        $response = $this->get('/device/list');
        $response->assertStatus(200);
        $response->assertSeeText('Test device');
        $response->assertSeeText('test location');
    }
}
