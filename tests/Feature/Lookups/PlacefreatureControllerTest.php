<?php

namespace Tests\Feature\Lookups;

use App\Models\Occurrence;
use App\Models\Placefreature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlacefreatureControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/placefreature'));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        Placefreature::factory()->create();

        $this->get('/placefreature')->assertOk();
    }

    public function test_non_admin_cannot_create_a_placefreature(): void
    {
        $this->actingAsUser();

        $response = $this->post('/placefreature/create', ['name' => 'Área rural']);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_placefreature(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/placefreature/create', ['name' => 'zona rural']);

        $response->assertRedirect(route('index-placefreature'));
        $this->assertDatabaseHas('placefreatures', ['name' => 'Zona rural']);
    }

    public function test_admin_can_update_a_placefreature(): void
    {
        $this->actingAsAdmin();
        $freature = Placefreature::factory()->create();

        $response = $this->put("/placefreature/{$freature->id}/update", ['name' => 'atualizado']);

        $response->assertRedirect(route('index-placefreature', $freature->id));
        $this->assertSame('Atualizado', $freature->fresh()->name);
    }

    public function test_admin_can_delete_an_unused_placefreature(): void
    {
        $this->actingAsAdmin();
        $freature = Placefreature::factory()->create();

        $response = $this->delete("/placefreature/{$freature->id}");

        $response->assertRedirect(route('index-placefreature'));
        $this->assertDatabaseMissing('placefreatures', ['id' => $freature->id]);
    }

    public function test_admin_cannot_delete_a_placefreature_used_by_an_occurrence(): void
    {
        $this->actingAsAdmin();
        $freature = Placefreature::factory()->create();
        Occurrence::factory()->create(['placefreature_id' => $freature->id]);

        $response = $this->delete("/placefreature/{$freature->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('placefreatures', ['id' => $freature->id]);
    }
}
