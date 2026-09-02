<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsUser(array $attributes = []): User
    {
        $user = User::factory()->create($attributes);

        $this->actingAs($user);

        return $user;
    }

    protected function actingAsAdmin(array $attributes = []): User
    {
        return $this->actingAsUser([...$attributes, 'admin' => true]);
    }

    protected function assertRedirectsToLogin(TestResponse $response): void
    {
        $response->assertRedirect(route('login'));
    }
}
