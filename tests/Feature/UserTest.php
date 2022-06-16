<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_be_created()
    {
        $response = $this->post($this->registerUrl(), $this->data());
        $this->assertCount(1, User::all());
        $response->assertStatus(201);
    }

    public function test_a_user_can_login()
    {
        $this->withExceptionHandling();
        $this->post($this->registerUrl(), array_merge($this->data()));
        $response = $this->post('/api/auth/login', array_merge($this->data(), ['name' => '']));
        $this->assertCount(1, User::all());
        $response->assertStatus(200);
    }

    public function test_a_user_name_is_required() {
        $response = $this->post($this->registerUrl(), array_merge($this->data(), ['name' => '']));
        $response->assertJsonValidationErrors('name');
    }

    public function test_a_user_email_is_required() {
        $response = $this->post($this->registerUrl(), array_merge($this->data(), ['email' => '']));
        $response->assertJsonValidationErrors('email');
    }

    public function test_a_user_password_is_required() {
        $response = $this->post($this->registerUrl(), array_merge($this->data(), ['password' => '']));
        $response->assertJsonValidationErrors('password');
    }

    protected function data() {
        return [
            'name' => 'Antonio',
            'email' => 'antonio@tecempregos.com.br',
            'password' => '10203040'
        ];
    }

    protected function registerUrl() {
        return "/api/auth/register";
    }

    protected function loginUrl() {
        return "/api/auth/login";
    }
}
