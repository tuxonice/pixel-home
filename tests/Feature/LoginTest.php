<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Database\Factories\UserFactory;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNotLoggedInUserRedirectToLogin()
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }
    
    public function testUserCanViewALoginForm()
    {
        $response = $this->get('/login');

        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }
    
    public function testUserCannotViewALoginFormWhenAuthenticated()
    {
        $user = User::factory()->make();

        $response = $this->actingAs($user)->get('/login');

        $response->assertRedirect('/dashboard');
    }
    
    public function testUserCanLoginWithCorrectCredentials()
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
    }
    
    public function testUserCannotLoginWithIncorrectPassword()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        
        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'invalid-password',
        ]);
        
        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertTrue(session()->hasOldInput('email'));
        $this->assertFalse(session()->hasOldInput('password'));
        $this->assertGuest();
    }
    
    public function testRememberMeFunctionality()
    {
        $user = User::factory()->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'i-love-laravel'),
        ]);
        
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
        ]);
        
        $response->assertRedirect('/dashboard');
        $response->assertCookie(Auth::guard()->getRecallerName(), vsprintf('%s|%s|%s', [
            $user->id,
            $user->getRememberToken(),
            $user->password,
        ]));
        $this->assertAuthenticatedAs($user);
    }
}