<?php

namespace Tests\Feature\User;

use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_can_login()
    {
        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData()));
        $response = $this->post(UserData::loginUrl(), array_merge(UserData::newUserData(), ['name' => '']));
        $this->assertCount(1, User::all());
        $response->assertStatus(200);
    }

    public function test_user_email_has_already_been_taken()
    {
        $this->post(UserData::registerUrl(), UserData::newUserData());
        $response = $this->post(UserData::registerUrl(), UserData::newUserData());
        $this->assertCount(1, User::all());
        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_a_user_name_is_required() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['name' => '']));
        $response->assertJsonValidationErrors('name');
    }

    public function test_a_user_email_is_required() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['email' => '']));
        $response->assertJsonValidationErrors('email');
    }

    public function test_a_user_password_is_required() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['password' => '']));
        $response->assertJsonValidationErrors('password');
    }

    public function test_a_password_confirmation_matches() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['password' => '102030', 'password_confirmation' => '123456']));
        $response->assertJsonValidationErrors('password');
    }

    public function test_a_user_type_is_required() {
        $this->withExceptionHandling();
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => '']));
        $response->assertJsonValidationErrors('type');
    }

    public function test_a_user_can_reset_his_password() {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => 1]));
        $this->assertCount(1, User::all());
        $response->assertStatus(201);

        $user = User::first();

        $response = $this->post(UserData::urlResetPassword(), [
            'email' => $user->email,
            'url-back' => 'http://localhost:8000/'
        ]);

        $this->assertCount(1, PasswordReset::all());
        $token = PasswordReset::first()->token;
        $response->assertStatus(200);

        $response = $this->post(UserData::urlResetPasswordWithtoken(), [
            'email' => $user->email,
            'token' => $token,
            'password' => '1020304050',
            'password_confirmation' => '1020304050'
        ]);

        $this->assertCount(0, PasswordReset::all());

        $response->assertStatus(200);
    }
}
