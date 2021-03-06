<?php

namespace Tests\Feature\User;

use Carbon\Carbon;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserData
{
    public static function newUserData() {
        return [
            'name' => 'Antonio',
            'email' => 'antonio@empregos.com.br',
            'password' => '10203040',
            'password_confirmation' => '10203040',
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

    public static function patch($id) {
        return "/api/company/jobs/" . $id;
    }

    public static function urlPostJob() {
        return "/api/company/jobs";

    }

    public static function urlDeleteJob($id) {
        return "/api/company/jobs/" . $id ;
    }

    public static function urlResetPassword() {
        return "api/auth/reset-password";
    }

    public static function urlResetPasswordWithtoken() {
        return "api/auth/reset-password-with-token";
    }

    public static function newJobData() {
        return [
            'title' => 'new job post',
            'companyName' => 'Company',
            'description' => nl2br('My job description'),
            'email' => 'mail@domain.com',
            'phone' => 'my phone',
            'expirationDate' => Carbon::now()->addDays(7)->format('d/m/Y'),
            'status' => 1
        ];
    }
}
