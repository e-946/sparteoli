<?php

namespace Tests\Feature;

use App\Models\Occurrence;
use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceControllerTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'who' => 'Equipe Alfa',
            'where' => 'Sala de estar',
            'how' => 'Pela janela',
            'what' => 'Motosserra',
        ];
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $occurrence = Occurrence::factory()->create();

        $this->assertRedirectsToLogin($this->get("/occurrence/{$occurrence->id}/resource"));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/resource")->assertOk();
    }

    public function test_any_authenticated_user_can_view_the_create_form(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $this->get("/occurrence/{$occurrence->id}/resource/create")->assertOk();
    }

    public function test_any_authenticated_user_can_create_a_resource(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $response = $this->post("/occurrence/{$occurrence->id}/resource/create", $this->validPayload());

        $response->assertRedirect(route('index-resource', $occurrence->id));
        $this->assertDatabaseHas('resources', [
            'who' => 'EQUIPE ALFA',
            'occurrence_id' => $occurrence->id,
        ]);
    }

    public function test_creating_a_resource_requires_the_rules(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $response = $this->from("/occurrence/{$occurrence->id}/resource/create")
            ->post("/occurrence/{$occurrence->id}/resource/create", []);

        $response->assertSessionHasErrors(['who', 'where', 'how', 'what']);
    }

    public function test_any_authenticated_user_can_view_a_resource(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/resource/{$resource->id}")->assertOk();
    }

    public function test_non_admin_cannot_view_the_edit_form(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/resource/{$resource->id}/update")->assertForbidden();
    }

    public function test_admin_can_view_the_edit_form(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->get("/occurrence/{$occurrence->id}/resource/{$resource->id}/update")->assertOk();
    }

    public function test_non_admin_cannot_update_a_resource(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $response = $this->put(
            "/occurrence/{$occurrence->id}/resource/{$resource->id}/update",
            $this->validPayload()
        );

        $response->assertForbidden();
    }

    public function test_admin_can_update_a_resource(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $response = $this->put("/occurrence/{$occurrence->id}/resource/{$resource->id}/update", [
            ...$this->validPayload(),
            'what' => 'corda',
        ]);

        $response->assertRedirect(route('show-resource', [
            'occurrence_id' => $occurrence->id,
            'id' => $resource->id,
        ]));
        $this->assertSame('Corda', $resource->fresh()->what);
    }

    public function test_non_admin_cannot_delete_a_resource(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->delete("/occurrence/{$occurrence->id}/resource/{$resource->id}")->assertForbidden();
    }

    public function test_admin_can_delete_a_resource(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $response = $this->delete("/occurrence/{$occurrence->id}/resource/{$resource->id}");

        $response->assertRedirect(route('index-resource', $occurrence->id));
        $this->assertDatabaseMissing('resources', ['id' => $resource->id]);
    }
}
