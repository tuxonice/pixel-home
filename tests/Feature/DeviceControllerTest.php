<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

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
        $user = factory(User::class)->create([
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
        $user = factory(User::class)->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticatedAs($user);
        $response = $this->get('/device/create');
        
        $response->assertStatus(200);
        $response->assertViewIs('devices.create');
        
    }

}