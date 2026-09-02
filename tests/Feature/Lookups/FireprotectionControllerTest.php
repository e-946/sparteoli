<?php

namespace Tests\Feature\Lookups;

use App\Models\Fireprotection;
use App\Models\Occurrence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FireprotectionControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/fireprotection'));
    }

    public function test_any_authenticated_user_can_view_the_index_and_show(): void
    {
        $this->actingAsUser();
        $protection = Fireprotection::factory()->create();

        $this->get('/fireprotection')->assertOk();
        $this->get("/fireprotection/{$protection->id}")->assertOk();
    }

    public function test_non_admin_cannot_create_a_fireprotection(): void
    {
        $this->actingAsUser();

        $response = $this->post('/fireprotection/create', ['name' => 'Extintor']);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_fireprotection(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/fireprotection/create', ['name' => 'extintor']);

        $response->assertRedirect(route('index-fireprotection'));
        $this->assertDatabaseHas('fireprotections', ['name' => 'Extintor']);
    }

    public function test_admin_can_update_a_fireprotection(): void
    {
        $this->actingAsAdmin();
        $protection = Fireprotection::factory()->create();

        $response = $this->put("/fireprotection/{$protection->id}/update", ['name' => 'atualizado']);

        $response->assertRedirect(route('index-fireprotection'));
        $this->assertSame('Atualizado', $protection->fresh()->name);
    }

    public function test_admin_can_delete_an_unused_fireprotection(): void
    {
        $this->actingAsAdmin();
        $protection = Fireprotection::factory()->create();

        $response = $this->delete("/fireprotection/{$protection->id}");

        $response->assertRedirect(route('index-fireprotection'));
        $this->assertDatabaseMissing('fireprotections', ['id' => $protection->id]);
    }

    public function test_admin_cannot_delete_a_fireprotection_used_by_an_occurrence(): void
    {
        $this->actingAsAdmin();
        $protection = Fireprotection::factory()->create();
        $occurrence = Occurrence::factory()->create();
        $occurrence->fireprotections()->attach($protection);

        $response = $this->delete("/fireprotection/{$protection->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('fireprotections', ['id' => $protection->id]);
    }
}
