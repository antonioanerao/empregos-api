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
    public function test_user_can_register_as_candidate()
    {
        $response = $this->post($this->registerUrl(), $this->data());
        $this->assertCount(1, User::all());
        $response->assertStatus(201);
    }

    public function test_user_can_register_as_company()
    {
        $response = $this->post($this->registerUrl(), array_merge($this->data(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $response->assertStatus(201);
    }

    public function test_user_email_has_already_been_taken()
    {
        $this->post($this->registerUrl(), $this->data());
        $response = $this->post($this->registerUrl(), $this->data());
        $this->assertCount(1, User::all());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_a_user_can_login()
    {
        $this->post($this->registerUrl(), array_merge($this->data()));
        $response = $this->post($this->loginUrl(), array_merge($this->data(), ['name' => '']));
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

    public function test_a_user_type_is_required() {
        $this->withExceptionHandling();
        $response = $this->post($this->registerUrl(), array_merge($this->data(), ['type' => '']));
        $response->assertJsonValidationErrors('type');
    }

    protected function data() {
        return [
            'name' => 'Antonio',
            'email' => 'antonio@tecempregos.com.br',
            'password' => '10203040',
            'type' => 1,
            'user_id' => 1
        ];
    }

    protected function registerUrl() {
        return "/api/auth/register";
    }

    protected function loginUrl() {
        return "/api/auth/login";
    }
}
