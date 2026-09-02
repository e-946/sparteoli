<?php

namespace Tests\Feature;

use App\Models\Nature;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LookupSearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/lookup-search/nature'));
    }

    public function test_unknown_resource_404s(): void
    {
        $this->actingAsUser();

        $this->get('/lookup-search/unknown')->assertNotFound();
    }

    public function test_any_authenticated_user_can_search_a_resource(): void
    {
        $this->actingAsUser();
        Nature::factory()->create(['name' => 'Incêndio']);
        Nature::factory()->create(['name' => 'Busca e salvamento']);

        $response = $this->get('/lookup-search/nature?q=inc');

        $response->assertOk();
        $response->assertJsonCount(1);
        $response->assertJsonFragment(['name' => 'Incêndio']);
    }

    public function test_searching_types_includes_the_nature_name(): void
    {
        $this->actingAsUser();
        $nature = Nature::factory()->create(['name' => 'Incêndio']);
        Type::factory()->create(['name' => 'Curto circuito', 'nature_id' => $nature->id]);

        $response = $this->get('/lookup-search/type');

        $response->assertOk();
        $response->assertJsonFragment(['nature_name' => 'Incêndio']);
    }

    public function test_search_without_query_returns_up_to_twenty_results(): void
    {
        $this->actingAsUser();
        Nature::factory()->count(25)->create();

        $response = $this->get('/lookup-search/nature');

        $response->assertOk();
        $response->assertJsonCount(20);
    }

    public function test_non_admin_cannot_quick_create(): void
    {
        $this->actingAsUser();

        $response = $this->post('/lookup-search/nature', ['name' => 'Nova natureza']);

        $response->assertForbidden();
    }

    public function test_admin_can_quick_create_a_resource(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/lookup-search/nature', ['name' => 'nova natureza']);

        $response->assertOk();
        $response->assertJsonFragment(['name' => 'Nova natureza']);
        $this->assertDatabaseHas('natures', ['name' => 'Nova natureza']);
    }

    public function test_admin_quick_create_for_type_requires_a_valid_nature(): void
    {
        $this->actingAsAdmin();

        $response = $this->postJson('/lookup-search/type', ['name' => 'Novo Tipo', 'nature_id' => 999]);

        $response->assertStatus(422);
    }

    public function test_admin_quick_create_for_type_returns_the_nature_name(): void
    {
        $this->actingAsAdmin();
        $nature = Nature::factory()->create(['name' => 'Incêndio']);

        $response = $this->post('/lookup-search/type', [
            'name' => 'novo tipo',
            'nature_id' => $nature->id,
        ]);

        $response->assertOk();
        $response->assertJsonFragment(['nature_name' => 'Incêndio']);
    }

    public function test_quick_create_for_unknown_resource_404s(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/lookup-search/unknown', ['name' => 'x']);

        $response->assertNotFound();
    }
}
