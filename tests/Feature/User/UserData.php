<?php

namespace Tests\Feature\User;

use Carbon\Carbon;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserData
{
    public static function data() {
        return [
            'name' => 'Antonio',
            'email' => 'antonio@empregos.com.br',
            'password' => '10203040',
            'type' => 1,
            'user_id' => 1
        ];
    }

    public static function registerUrl() {
        return "/api/auth/register";
    }

    public static function loginUrl() {
        return "/api/auth/login";
    }

    public static function headers($user) {
        return [
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($user)
        ];
    }

    public static function newJobData($user) {
        return [
            'user_id' => $user,
            'title' => 'my new job',
            'companyName' => 'Company',
            'description' => nl2br('My job description'),
            'email' => 'mail@domain.com',
            'phone' => 'my phone',
            'expirationDate' => Carbon::now()->addDays(7),
            'status' => 1
        ];
    }
}