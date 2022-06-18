<?php

namespace Tests\Feature\User\UserCompany;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\User\UserData;
use Tests\TestCase;

class UserTest extends TestCase
{
   use RefreshDatabase;

    public function test_user_can_register_as_company()
    {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::data(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $response->assertStatus(201);
    }
}
