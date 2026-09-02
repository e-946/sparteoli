<?php

namespace Tests\Feature;

use App\Models\Occurrence;
use App\Models\Problem;
use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VictimControllerTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'name' => 'Maria Silva',
            'age' => 30,
            'sex' => 'F',
            'rescuer_id' => Rescuer::factory()->create()->id,
            'fatal' => false,
            'conscious' => true,
            'problemForSave' => [Problem::factory()->create()->id],
        ];
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $occurrence = Occurrence::factory()->create();

        $this->assertRedirectsToLogin($this->get("/occurrence/{$occurrence->id}/victim"));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/victim")->assertOk();
    }

    public function test_any_authenticated_user_can_view_the_create_form(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $this->get("/occurrence/{$occurrence->id}/victim/create")->assertOk();
    }

    public function test_any_authenticated_user_can_create_a_victim_with_problems(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $response = $this->post("/occurrence/{$occurrence->id}/victim/create", $this->validPayload());

        $response->assertRedirect(route('index-victim', $occurrence->id));
        $this->assertDatabaseHas('victims', ['name' => 'Maria silva', 'occurrence_id' => $occurrence->id]);
    }

    public function test_creating_a_victim_without_problems_does_not_persist_it(): void
    {
        // Documents current behavior: VictimController::store only invokes
        // VictimCreator (which actually persists the victim) when
        // problemForSave is non-empty, even though it always redirects
        // as if the victim had been created.
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $response = $this->post("/occurrence/{$occurrence->id}/victim/create", [
            ...$this->validPayload(),
            'problemForSave' => [],
        ]);

        $response->assertRedirect(route('index-victim', $occurrence->id));
        $this->assertDatabaseMissing('victims', ['occurrence_id' => $occurrence->id]);
    }

    public function test_creating_a_victim_requires_the_rules(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $response = $this->from("/occurrence/{$occurrence->id}/victim/create")
            ->post("/occurrence/{$occurrence->id}/victim/create", []);

        $response->assertSessionHasErrors(['name', 'age', 'sex', 'rescuer_id', 'fatal']);
    }

    public function test_any_authenticated_user_can_view_a_victim(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/victim/{$victim->id}")->assertOk();
    }

    public function test_non_admin_cannot_view_the_edit_form(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/victim/{$victim->id}/update")->assertForbidden();
    }

    public function test_admin_can_view_the_edit_form(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/victim/{$victim->id}/update")->assertOk();
    }

    public function test_non_admin_cannot_update_a_victim(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $response = $this->put(
            "/occurrence/{$occurrence->id}/victim/{$victim->id}/update",
            $this->validPayload()
        );

        $response->assertForbidden();
    }

    public function test_admin_can_update_a_victim_and_sync_problems(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);
        $problem = Problem::factory()->create();

        $response = $this->put("/occurrence/{$occurrence->id}/victim/{$victim->id}/update", [
            ...$this->validPayload(),
            'name' => 'Nova Vitima',
            'problemForSave' => [$problem->id],
        ]);

        $response->assertRedirect(route('show-victim', ['occurrence_id' => $occurrence->id, 'id' => $victim->id]));
        $victim->refresh();
        $this->assertSame('Nova vitima', $victim->name);
        $this->assertTrue($victim->problems->contains($problem));
    }

    public function test_non_admin_cannot_delete_a_victim(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->delete("/occurrence/{$occurrence->id}/victim/{$victim->id}")->assertForbidden();
    }

    public function test_admin_can_delete_a_victim(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $response = $this->delete("/occurrence/{$occurrence->id}/victim/{$victim->id}");

        $response->assertRedirect(route('index-victim', $occurrence->id));
        $this->assertDatabaseMissing('victims', ['id' => $victim->id]);
    }
}
