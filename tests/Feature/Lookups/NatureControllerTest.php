<?php

namespace Tests\Feature\Lookups;

use App\Models\Nature;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NatureControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/nature'));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        Nature::factory()->create();

        $response = $this->get('/nature');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Lookups/Index', shouldExist: false));
    }

    public function test_any_authenticated_user_can_view_a_nature(): void
    {
        $this->actingAsUser();
        $nature = Nature::factory()->create();

        $response = $this->get("/nature/{$nature->id}");

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Lookups/Show', shouldExist: false));
    }

    public function test_viewing_a_missing_nature_404s(): void
    {
        $this->actingAsUser();

        $response = $this->get('/nature/999');

        $response->assertNotFound();
    }

    public function test_non_admin_cannot_create_a_nature(): void
    {
        $this->actingAsUser();

        $response = $this->post('/nature/create', ['name' => 'Nova Natureza']);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_nature(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/nature/create', ['name' => 'nova natureza']);

        $response->assertRedirect(route('index-nature'));
        $this->assertDatabaseHas('natures', ['name' => 'Nova natureza']);
    }

    public function test_creating_a_nature_requires_a_name(): void
    {
        $this->actingAsAdmin();

        $response = $this->from('/nature/create')->post('/nature/create', []);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_a_nature(): void
    {
        $this->actingAsAdmin();
        $nature = Nature::factory()->create();

        $response = $this->put("/nature/{$nature->id}/update", ['name' => 'atualizada']);

        $response->assertRedirect(route('index-nature'));
        $this->assertSame('Atualizada', $nature->fresh()->name);
    }

    public function test_non_admin_cannot_update_a_nature(): void
    {
        $this->actingAsUser();
        $nature = Nature::factory()->create(['name' => 'Original']);

        $response = $this->put("/nature/{$nature->id}/update", ['name' => 'hacked']);

        $response->assertForbidden();
        $this->assertSame('Original', $nature->fresh()->name);
    }

    public function test_admin_can_delete_an_unused_nature(): void
    {
        $this->actingAsAdmin();
        $nature = Nature::factory()->create();

        $response = $this->delete("/nature/{$nature->id}");

        $response->assertRedirect(route('index-nature'));
        $this->assertDatabaseMissing('natures', ['id' => $nature->id]);
    }

    public function test_admin_cannot_delete_a_nature_that_has_types(): void
    {
        $this->actingAsAdmin();
        $nature = Nature::factory()->create();
        Type::factory()->create(['nature_id' => $nature->id]);

        $response = $this->delete("/nature/{$nature->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('natures', ['id' => $nature->id]);
    }

    public function test_non_admin_cannot_delete_a_nature(): void
    {
        $this->actingAsUser();
        $nature = Nature::factory()->create();

        $response = $this->delete("/nature/{$nature->id}");

        $response->assertForbidden();
        $this->assertDatabaseHas('natures', ['id' => $nature->id]);
    }
}
