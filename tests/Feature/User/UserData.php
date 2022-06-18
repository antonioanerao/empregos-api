<?php

namespace Tests\Feature\User;

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
}
