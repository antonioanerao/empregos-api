<?php

namespace Tests\Feature\User\UserCompany;

use App\Models\Job;
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

    public function test_a_company_can_post_a_job() {
        $this->post(UserData::registerUrl(), array_merge(UserData::data(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $user = User::first();

        $response = $this->withHeaders(UserData::headers($user))->post('api/jobs', UserData::newJobData($user->id));

        $this->assertCount(1, Job::all());
        $response->assertStatus(201);
    }
}
