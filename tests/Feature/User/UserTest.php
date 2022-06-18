<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_login()
    {
        $this->post(UserData::registerUrl(), array_merge(UserData::data()));
        $response = $this->post(UserData::loginUrl(), array_merge(UserData::data(), ['name' => '']));
        $this->assertCount(1, User::all());
        $response->assertStatus(200);
    }

    public function test_user_email_has_already_been_taken()
    {
        $this->post(UserData::registerUrl(), UserData::data());
        $response = $this->post(UserData::registerUrl(), UserData::data());
        $this->assertCount(1, User::all());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_a_user_name_is_required() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::data(), ['name' => '']));
        $response->assertJsonValidationErrors('name');
    }

    public function test_a_user_email_is_required() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::data(), ['email' => '']));
        $response->assertJsonValidationErrors('email');
    }

    public function test_a_user_password_is_required() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::data(), ['password' => '']));
        $response->assertJsonValidationErrors('password');
    }

    public function test_a_user_type_is_required() {
        $this->withExceptionHandling();
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::data(), ['type' => '']));
        $response->assertJsonValidationErrors('type');
    }
}
