<?php

namespace Tests\Feature;

use Tests\TestCase;

class LoginTest extends TestCase
{
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
}
