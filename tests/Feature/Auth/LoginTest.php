<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_the_login_form(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Auth/Login', shouldExist: false));
    }

    public function test_authenticated_user_is_redirected_away_from_login_form(): void
    {
        $this->actingAsUser();

        $response = $this->get(route('login'));

        $response->assertRedirect('/home');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $response = $this->post('/login', [
            'register' => $user->register,
            'password' => 'password123',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_password(): void
    {
        $user = User::factory()->create(['password' => bcrypt('password123')]);

        $response = $this->from('/login')->post('/login', [
            'register' => $user->register,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('register');
        $this->assertGuest();
    }

    public function test_login_requires_register_and_password(): void
    {
        $response = $this->from('/login')->post('/login', []);

        $response->assertSessionHasErrors(['register', 'password']);
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $this->actingAsUser();

        $response = $this->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
