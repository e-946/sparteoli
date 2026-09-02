<?php

namespace Tests\Feature\Lookups;

use App\Models\Occurrence;
use App\Models\Placeuse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceuseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/placeuse'));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        Placeuse::factory()->create();

        $this->get('/placeuse')->assertOk();
    }

    public function test_non_admin_cannot_create_a_placeuse(): void
    {
        $this->actingAsUser();

        $response = $this->post('/placeuse/create', ['name' => 'Residencial']);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_placeuse(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/placeuse/create', ['name' => 'residencial']);

        $response->assertRedirect(route('index-placeuse'));
        $this->assertDatabaseHas('placeuses', ['name' => 'Residencial']);
    }

    public function test_admin_can_update_a_placeuse(): void
    {
        $this->actingAsAdmin();
        $use = Placeuse::factory()->create();

        $response = $this->put("/placeuse/{$use->id}/update", ['name' => 'atualizado']);

        $response->assertRedirect(route('index-placeuse', $use->id));
        $this->assertSame('Atualizado', $use->fresh()->name);
    }

    public function test_admin_can_delete_an_unused_placeuse(): void
    {
        $this->actingAsAdmin();
        $use = Placeuse::factory()->create();

        $response = $this->delete("/placeuse/{$use->id}");

        $response->assertRedirect(route('index-placeuse'));
        $this->assertDatabaseMissing('placeuses', ['id' => $use->id]);
    }

    public function test_admin_cannot_delete_a_placeuse_used_by_an_occurrence(): void
    {
        $this->actingAsAdmin();
        $use = Placeuse::factory()->create();
        Occurrence::factory()->create(['placeuse_id' => $use->id]);

        $response = $this->delete("/placeuse/{$use->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('placeuses', ['id' => $use->id]);
    }
}
