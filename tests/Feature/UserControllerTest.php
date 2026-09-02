<?php

namespace Tests\Feature;

use App\Models\Occurrence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/user'));
    }

    public function test_non_admin_cannot_view_the_user_index(): void
    {
        $this->actingAsUser();

        $this->get('/user')->assertForbidden();
    }

    public function test_admin_can_view_the_user_index(): void
    {
        $this->actingAsAdmin();
        User::factory()->create();

        $this->get('/user')->assertOk();
    }

    public function test_any_authenticated_user_can_view_another_users_profile(): void
    {
        $this->actingAsUser();
        $other = User::factory()->create();
        Occurrence::factory()->create(['user_id' => $other->id]);

        $response = $this->get("/user/{$other->id}");

        $response->assertOk();
        $page = json_decode(json_encode($response->viewData('page')), true);
        $this->assertSame(1, $page['props']['occurrencesCount']);
    }

    public function test_viewing_a_missing_user_404s(): void
    {
        $this->actingAsUser();

        $this->get('/user/999')->assertNotFound();
    }

    public function test_admin_can_update_a_user(): void
    {
        $this->actingAsAdmin();
        $other = User::factory()->create(['name' => 'Original', 'register' => '1111111111']);

        $response = $this->put("/user/{$other->id}/update", [
            'name' => 'updated name',
            'register' => '2222222222',
            'admin' => true,
        ]);

        $response->assertRedirect(route('show-user', $other->id));
        $other->refresh();
        $this->assertSame('Updated Name', $other->name);
        $this->assertSame('2222222222', $other->register);
        $this->assertTrue($other->admin);
    }

    public function test_non_admin_can_also_update_another_users_record(): void
    {
        // Documents current behavior: unlike edit-user's sibling routes
        // (index-user, destroy-user), update-user is NOT behind the
        // 'can:admin' gate, so any authenticated user can rename another
        // user and grant them admin. This looks like an authorization gap
        // rather than intended behavior.
        $this->actingAsUser();
        $other = User::factory()->create(['admin' => false]);

        $response = $this->put("/user/{$other->id}/update", [
            'name' => 'hijacked',
            'admin' => true,
        ]);

        $response->assertRedirect(route('show-user', $other->id));
        $this->assertTrue($other->fresh()->admin);
    }

    public function test_updating_a_user_keeps_the_register_when_not_provided(): void
    {
        $this->actingAsAdmin();
        $other = User::factory()->create(['register' => '1111111111']);

        $this->put("/user/{$other->id}/update", ['name' => 'updated name']);

        $this->assertSame('1111111111', $other->fresh()->register);
    }

    public function test_non_admin_cannot_delete_a_user(): void
    {
        $this->actingAsUser();
        $other = User::factory()->create();

        $this->delete("/user/{$other->id}")->assertForbidden();
    }

    public function test_admin_can_delete_a_user(): void
    {
        $this->actingAsAdmin();
        $other = User::factory()->create();

        $response = $this->delete("/user/{$other->id}");

        $response->assertRedirect(route('index-user'));
        $this->assertDatabaseMissing('users', ['id' => $other->id]);
    }

    public function test_user_can_view_their_own_profile(): void
    {
        $user = $this->actingAsUser();

        $response = $this->get('/profile');

        $response->assertOk();
        $page = json_decode(json_encode($response->viewData('page')), true);
        $this->assertSame($user->id, $page['props']['user']['id']);
    }

    public function test_user_can_view_their_own_change_password_form(): void
    {
        $this->actingAsUser();

        $this->get('/profile/password')->assertOk();
    }

    public function test_non_admin_cannot_view_another_users_change_password_form(): void
    {
        $this->actingAsUser();
        $other = User::factory()->create();

        $this->get("/profile/password/{$other->id}")->assertForbidden();
    }

    public function test_admin_can_view_another_users_change_password_form(): void
    {
        $this->actingAsAdmin();
        $other = User::factory()->create();

        $this->get("/profile/password/{$other->id}")->assertOk();
    }

    public function test_user_can_change_their_own_password(): void
    {
        $user = $this->actingAsUser();

        $response = $this->put("/profile/password/{$user->id}", [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('profile'));
        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_admin_can_change_another_users_password(): void
    {
        $this->actingAsAdmin();
        $other = User::factory()->create();

        $response = $this->put("/profile/password/{$other->id}", [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('show-user', $other->id));
        $this->assertTrue(Hash::check('new-password', $other->fresh()->password));
    }

    public function test_non_admin_cannot_change_another_users_password(): void
    {
        $this->actingAsUser();
        $other = User::factory()->create(['password' => Hash::make('original')]);

        $response = $this->put("/profile/password/{$other->id}", [
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertTrue(Hash::check('original', $other->fresh()->password));
    }

    public function test_changing_password_requires_confirmation_and_min_length(): void
    {
        $user = $this->actingAsUser();

        $response = $this->from('/profile/password')->put("/profile/password/{$user->id}", [
            'password' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
