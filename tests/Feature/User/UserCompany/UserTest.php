<?php

namespace Tests\Feature\User\UserCompany;

use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\User\UserData;
use Tests\TestCase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

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
        $this->withExceptionHandling();

        $this->post(UserData::registerUrl(), array_merge(UserData::data(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $user = User::first();

        $headers = [
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($user)
        ];

        $response = $this->withHeaders($headers)->post('api/jobs', [
            'user_id' => $user->id,
            'title' => 'my new job',
            'companyName' => 'Company',
            'description' => nl2br('My job description'),
            'email' => 'mail@domain.com',
            'phone' => 'my phone',
            'expirationDate' => Carbon::now()->addDays(7),
            'status' => 1
        ]);

        $this->assertCount(1, Job::all());

        $response->assertStatus(201);
    }
}
