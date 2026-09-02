<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/register');

        $this->assertRedirectsToLogin($response);
    }

    public function test_non_admin_cannot_view_the_registration_form(): void
    {
        $this->actingAsUser();

        $response = $this->get('/register');

        $response->assertForbidden();
    }

    public function test_admin_can_view_the_registration_form(): void
    {
        $this->actingAsAdmin();

        $response = $this->get('/register');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Auth/Register', shouldExist: false));
    }

    public function test_non_admin_cannot_create_a_user(): void
    {
        $this->actingAsUser();

        $response = $this->post('/register', [
            'name' => 'New User',
            'register' => '1122334455',
            'password' => 'password',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('users', ['register' => '1122334455']);
    }

    public function test_admin_can_create_a_user(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/register', [
            'name' => 'new user',
            'register' => '1122334455',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('index-user'));
        $response->assertSessionHas('message', 'Usuário criado com sucesso');

        $this->assertDatabaseHas('users', [
            'register' => '1122334455',
            'name' => 'New User',
            'admin' => false,
        ]);
    }

    public function test_register_must_be_exactly_ten_characters(): void
    {
        $this->actingAsAdmin();

        $response = $this->from('/register')->post('/register', [
            'name' => 'New User',
            'register' => '123',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('register');
    }

    public function test_register_must_be_unique(): void
    {
        $this->actingAsAdmin();
        $existing = User::factory()->create(['register' => '1122334455']);

        $response = $this->from('/register')->post('/register', [
            'name' => 'New User',
            'register' => $existing->register,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('register');
    }

    public function test_password_must_be_at_least_eight_characters(): void
    {
        $this->actingAsAdmin();

        $response = $this->from('/register')->post('/register', [
            'name' => 'New User',
            'register' => '1122334455',
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
