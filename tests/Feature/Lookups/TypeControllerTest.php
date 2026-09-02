<?php

namespace Tests\Feature\Lookups;

use App\Models\Nature;
use App\Models\Occurrence;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/type'));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        Type::factory()->create();

        $response = $this->get('/type');

        $response->assertOk();
    }

    public function test_any_authenticated_user_can_view_a_type(): void
    {
        $this->actingAsUser();
        $type = Type::factory()->create();

        $response = $this->get("/type/{$type->id}");

        $response->assertOk();
    }

    public function test_non_admin_cannot_create_a_type(): void
    {
        $this->actingAsUser();
        $nature = Nature::factory()->create();

        $response = $this->post('/type/create', ['name' => 'Novo Tipo', 'nature_id' => $nature->id]);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_type(): void
    {
        $this->actingAsAdmin();
        $nature = Nature::factory()->create();

        $response = $this->post('/type/create', ['name' => 'novo tipo', 'nature_id' => $nature->id]);

        $response->assertRedirect(route('index-type'));
        $this->assertDatabaseHas('types', ['name' => 'Novo tipo', 'nature_id' => $nature->id]);
    }

    public function test_creating_a_type_requires_an_existing_nature(): void
    {
        $this->actingAsAdmin();

        $response = $this->from('/type/create')->post('/type/create', ['name' => 'Novo Tipo', 'nature_id' => 999]);

        $response->assertSessionHasErrors('nature_id');
    }

    public function test_admin_can_update_a_type(): void
    {
        $this->actingAsAdmin();
        $type = Type::factory()->create();
        $nature = Nature::factory()->create();

        $response = $this->put("/type/{$type->id}/update", ['name' => 'atualizado', 'nature_id' => $nature->id]);

        $response->assertRedirect(route('index-type'));
        $type->refresh();
        $this->assertSame('Atualizado', $type->name);
        $this->assertSame($nature->id, $type->nature_id);
    }

    public function test_admin_can_delete_an_unused_type(): void
    {
        $this->actingAsAdmin();
        $type = Type::factory()->create();

        $response = $this->delete("/type/{$type->id}");

        $response->assertRedirect(route('index-type'));
        $this->assertDatabaseMissing('types', ['id' => $type->id]);
    }

    public function test_admin_cannot_delete_a_type_that_has_occurrences(): void
    {
        $this->actingAsAdmin();
        $type = Type::factory()->create();
        Occurrence::factory()->create(['type_id' => $type->id]);

        $response = $this->delete("/type/{$type->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('types', ['id' => $type->id]);
    }
}
