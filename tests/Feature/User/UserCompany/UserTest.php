<?php

namespace Tests\Feature\User\UserCompany;

use App\Models\Job;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\Feature\User\UserData;
use Tests\TestCase;

class UserTest extends TestCase
{
   use RefreshDatabase;

    public function test_user_can_register_as_company()
    {
        $response = $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $response->assertStatus(201);
    }

    public function test_a_company_can_post_a_job() {
        $this->withoutExceptionHandling();
        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $user = User::first();

        $response = $this->withHeaders(UserData::headers($user))->post(UserData::urlPostJob(), UserData::newJobData());

        $this->assertCount(1, Job::all());
        $response->assertStatus(201);
    }

    public function test_a_company_can_edit_a_job() {
        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $user = User::first();

        $response = $this->withHeaders(UserData::headers($user))
            ->post(UserData::urlPostJob(), UserData::newJobData());

        $job = Job::first();

        $this->assertCount(1, Job::all());
        $response->assertStatus(201);

        $response = $this->withHeaders(UserData::headers($user))
            ->patch(UserData::patch($job->id),
            array_merge(UserData::newJobData(), ['title' => 'my new title']));

        $this->assertEquals('my new title', Job::first()->title);

        $response->assertStatus(200);
    }

    public function test_a_company_cant_edit_a_job_from_another_company() {
        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => 2]));

        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(),
            ['email' => 'mail@domain.com', 'type' => 2]));

        $this->assertCount(2, User::all());

        $user = User::first();
        $user2 = User::latest()->orderBy('id', 'desc')->first();

        $response = $this->actingAs($user)
            ->post(UserData::urlPostJob(), UserData::newJobData());

        $response->assertStatus(201);
        $this->assertCount(1, Job::all());

        $response = $this->actingAs($user2)->patch(UserData::patch(Job::first()->id), array_merge(UserData::newJobData(), ['title' => 'my new title']));

        $response->assertStatus(401);
    }

    public function test_a_company_can_delete_a_job() {
        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => 2]));
        $this->assertCount(1, User::all());
        $user = User::first();

        $response = $this->withHeaders(UserData::headers($user))
            ->post(UserData::urlPostJob(), UserData::newJobData());

        $job = Job::first();

        $this->assertCount(1, Job::all());
        $response->assertStatus(201);

        $response = $this->withHeaders(UserData::headers($user))
            ->delete(UserData::urlDeleteJob($job->id));

        $this->assertCount(0, Job::all());
        $response->assertStatus(200);
    }

    public function test_a_company_cant_delete_a_job_from_another_company() {
        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(), ['type' => 2]));

        $this->post(UserData::registerUrl(), array_merge(UserData::newUserData(),
            ['email' => 'mail@domain.com', 'type' => 2]));

        $this->assertCount(2, User::all());

        $user = User::first();
        $user2 = User::latest()->orderBy('id', 'desc')->first();

        $response = $this->actingAs($user)
            ->post(UserData::urlPostJob(), UserData::newJobData());

        $response->assertStatus(201);

        $this->assertCount(1, Job::all());

        $response = $this->actingAs($user2)->delete(UserData::urlDeleteJob(Job::first()->id));

        $response->assertStatus(401);
    }

}
