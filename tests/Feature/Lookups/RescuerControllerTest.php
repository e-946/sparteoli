<?php

namespace Tests\Feature\Lookups;

use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RescuerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/rescuer'));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        Rescuer::factory()->create();

        $this->get('/rescuer')->assertOk();
    }

    public function test_non_admin_cannot_create_a_rescuer(): void
    {
        $this->actingAsUser();

        $response = $this->post('/rescuer/create', ['name' => 'Bombeiros']);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_rescuer(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/rescuer/create', ['name' => 'bombeiros']);

        $response->assertRedirect(route('index-rescuer'));
        $this->assertDatabaseHas('rescuers', ['name' => 'Bombeiros']);
    }

    public function test_admin_can_update_a_rescuer(): void
    {
        $this->actingAsAdmin();
        $rescuer = Rescuer::factory()->create();

        $response = $this->put("/rescuer/{$rescuer->id}/update", ['name' => 'atualizado']);

        $response->assertRedirect(route('index-rescuer', $rescuer->id));
        $this->assertSame('Atualizado', $rescuer->fresh()->name);
    }

    public function test_admin_can_delete_an_unused_rescuer(): void
    {
        $this->actingAsAdmin();
        $rescuer = Rescuer::factory()->create();

        $response = $this->delete("/rescuer/{$rescuer->id}");

        $response->assertRedirect(route('index-rescuer'));
        $this->assertDatabaseMissing('rescuers', ['id' => $rescuer->id]);
    }

    public function test_admin_cannot_delete_a_rescuer_used_by_a_victim(): void
    {
        $this->actingAsAdmin();
        $rescuer = Rescuer::factory()->create();
        Victim::factory()->create(['rescuer_id' => $rescuer->id]);

        $response = $this->delete("/rescuer/{$rescuer->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('rescuers', ['id' => $rescuer->id]);
    }
}
