<?php

namespace Tests\Helpers;

use Illuminate\Support\Facades\Http;

class AuthServiceFakerHelper
{
    public static function actAsClient()
    {
        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/me' => Http::response([
                "data" => [
                    "id" => 1,
                    "name" => "Ayana Runolfsson",
                    "email" => "gussie91@example.com",
                    "avatar" => null,
                    "active" => true,
                ]
            ])
        ]);
    }

    public static function actAsAdmin()
    {
        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/me' => Http::response([
                "data" => [
                    "id" => 1,
                    "name" => "Ms. Burdette Gibson III",
                    "email" => "zgreenfelder@example.net",
                    "avatar" => null,
                    "active" => true,
                    "roles" => [
                        ['id' => 1, 'title' => 'Администратор', 'name' => 'admin']
                    ]
                ]
            ])
        ]);
    }

    public static function actAsAdminGuest()
    {
        Http::fake([
            config('services.kfit.urls.auth') . '/api/v1/users/me' => Http::response([
                "data" => [
                    "id" => 1,
                    "name" => "Ms. Burdette Gibson III",
                    "email" => "zgreenfelder@example.net",
                    "avatar" => null,
                    "active" => true,
                    "roles" => [
                        ['id' => 2, 'title' => 'Гость', 'name' => 'guest']
                    ]
                ]
            ])
        ]);
    }
}
