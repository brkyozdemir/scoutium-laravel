<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_validation_error()
    {
        $response = $this->post('api/login');

        $response->assertStatus(418);
    }

    public function test_login_validation_error_without_password()
    {
        $response = $this->post('api/login', ['email' => 'berkay@scoutium.com']);

        $response->assertStatus(418);
    }

    public function test_register_validation_error()
    {
        $response = $this->post('api/register');

        $response->assertStatus(418);
    }

    public function test_register_validation_error_with_token()
    {
        $response = $this->post('api/register', ['token' => 'token']);

        $response->assertStatus(418);
    }

    public function test_login()
    {
        $response = $this->post('api/login', ['email' => 'berkay@scoutium.com', 'password' => 'password']);

        $response->assertStatus(200);
    }

    public function test_register()
    {
        $response = $this->post('api/login', ['email' => 'berkay@scoutium.com', 'password' => 'password']);

        $response->assertStatus(200);
    }
}
