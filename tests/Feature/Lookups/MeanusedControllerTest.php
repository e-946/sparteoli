<?php

namespace Tests\Feature\Lookups;

use App\Models\Meanused;
use App\Models\Occurrence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeanusedControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/meanused'));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        Meanused::factory()->create();

        $this->get('/meanused')->assertOk();
    }

    public function test_non_admin_cannot_create_a_meanused(): void
    {
        $this->actingAsUser();

        $response = $this->post('/meanused/create', ['name' => 'Telefone']);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_meanused(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/meanused/create', ['name' => 'telefone']);

        $response->assertRedirect(route('index-meanused'));
        $this->assertDatabaseHas('meanuseds', ['name' => 'Telefone']);
    }

    public function test_admin_can_update_a_meanused(): void
    {
        $this->actingAsAdmin();
        $mean = Meanused::factory()->create();

        $response = $this->put("/meanused/{$mean->id}/update", ['name' => 'atualizado']);

        $response->assertRedirect(route('index-meanused', $mean->id));
        $this->assertSame('Atualizado', $mean->fresh()->name);
    }

    public function test_admin_can_delete_an_unused_meanused(): void
    {
        $this->actingAsAdmin();
        $mean = Meanused::factory()->create();

        $response = $this->delete("/meanused/{$mean->id}");

        $response->assertRedirect(route('index-meanused'));
        $this->assertDatabaseMissing('meanuseds', ['id' => $mean->id]);
    }

    public function test_admin_cannot_delete_a_meanused_used_by_an_occurrence(): void
    {
        $this->actingAsAdmin();
        $mean = Meanused::factory()->create();
        Occurrence::factory()->create(['meanused_id' => $mean->id]);

        $response = $this->delete("/meanused/{$mean->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('meanuseds', ['id' => $mean->id]);
    }
}
