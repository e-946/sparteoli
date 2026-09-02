<?php

namespace Tests\Feature\Lookups;

use App\Models\Problem;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProblemControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/problem'));
    }

    public function test_any_authenticated_user_can_view_the_index_and_show(): void
    {
        $this->actingAsUser();
        $problem = Problem::factory()->create();

        $this->get('/problem')->assertOk();
        $this->get("/problem/{$problem->id}")->assertOk();
    }

    public function test_non_admin_cannot_create_a_problem(): void
    {
        $this->actingAsUser();

        $response = $this->post('/problem/create', ['name' => 'Fratura']);

        $response->assertForbidden();
    }

    public function test_admin_can_create_a_problem(): void
    {
        $this->actingAsAdmin();

        $response = $this->post('/problem/create', ['name' => 'fratura']);

        $response->assertRedirect(route('index-problem'));
        $this->assertDatabaseHas('problems', ['name' => 'Fratura']);
    }

    public function test_admin_can_update_a_problem(): void
    {
        $this->actingAsAdmin();
        $problem = Problem::factory()->create();

        $response = $this->put("/problem/{$problem->id}/update", ['name' => 'atualizado']);

        $response->assertRedirect(route('index-problem'));
        $this->assertSame('Atualizado', $problem->fresh()->name);
    }

    public function test_admin_can_delete_an_unused_problem(): void
    {
        $this->actingAsAdmin();
        $problem = Problem::factory()->create();

        $response = $this->delete("/problem/{$problem->id}");

        $response->assertRedirect(route('index-problem'));
        $this->assertDatabaseMissing('problems', ['id' => $problem->id]);
    }

    public function test_admin_cannot_delete_a_problem_used_by_a_victim(): void
    {
        $this->actingAsAdmin();
        $problem = Problem::factory()->create();
        $victim = Victim::factory()->create();
        $victim->problems()->attach($problem);

        $response = $this->delete("/problem/{$problem->id}");

        $response->assertSessionHasErrors('error');
        $this->assertDatabaseHas('problems', ['id' => $problem->id]);
    }
}
