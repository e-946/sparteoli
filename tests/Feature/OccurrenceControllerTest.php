<?php

namespace Tests\Feature;

use App\Models\Fireprotection;
use App\Models\Meanused;
use App\Models\Occurrence;
use App\Models\Placefreature;
use App\Models\Placeuse;
use App\Models\Resource;
use App\Models\Type;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OccurrenceControllerTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(): array
    {
        return [
            'date' => '2026-01-10',
            'call_time' => '08:00',
            'arrival_time' => '08:15',
            'end_time' => '09:00',
            'meanused_id' => Meanused::factory()->create()->id,
            'zip_code' => '30000-000',
            'street' => 'Rua das Flores',
            'number' => '100',
            'neighborhood' => 'Centro',
            'city' => 'Belo Horizonte',
            'state' => 'MG',
            'requester' => 'João da Silva',
            'requester_phone' => '31999998888',
            'resume' => 'Resumo da ocorrência',
            'placefreature_id' => Placefreature::factory()->create()->id,
            'placeuse_id' => Placeuse::factory()->create()->id,
            'place_preservation' => true,
            'filler_register' => '0123456789',
            'filler_name' => 'Carlos Souza',
            'filler_patent' => 'Sargento',
            'type_id' => Type::factory()->create()->id,
        ];
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->assertRedirectsToLogin($this->get('/occurrence'));
    }

    public function test_any_authenticated_user_can_view_the_index(): void
    {
        $this->actingAsUser();
        Occurrence::factory()->create();

        $response = $this->get('/occurrence');

        $response->assertOk();
    }

    public function test_any_authenticated_user_can_view_the_create_form(): void
    {
        $this->actingAsUser();

        $this->get('/occurrence/create')->assertOk();
    }

    public function test_any_authenticated_user_can_create_an_occurrence(): void
    {
        $user = $this->actingAsUser();

        $response = $this->post('/occurrence/create', $this->validPayload());

        $occurrence = Occurrence::sole();
        $response->assertRedirect(route('show-occurrence', $occurrence->id));
        $this->assertSame($user->id, $occurrence->user_id);
        $this->assertSame('Rua Das Flores, Nº 100', $occurrence->address);
    }

    public function test_creating_an_occurrence_attaches_fireprotections(): void
    {
        $this->actingAsUser();
        $protection = Fireprotection::factory()->create();

        $this->post('/occurrence/create', [
            ...$this->validPayload(),
            'protectionsForSave' => [$protection->id],
        ]);

        $occurrence = Occurrence::sole();
        $this->assertTrue($occurrence->fireprotections->contains($protection));
    }

    public function test_creating_an_occurrence_requires_the_rules(): void
    {
        $this->actingAsUser();

        $response = $this->from('/occurrence/create')->post('/occurrence/create', []);

        $response->assertSessionHasErrors([
            'date', 'meanused_id', 'zip_code', 'street', 'number', 'neighborhood',
            'city', 'state', 'requester', 'requester_phone', 'resume',
            'placefreature_id', 'placeuse_id', 'place_preservation',
            'filler_register', 'filler_name', 'filler_patent', 'type_id',
        ]);
    }

    public function test_any_authenticated_user_can_view_an_occurrence(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $this->get("/occurrence/{$occurrence->id}")->assertOk();
    }

    public function test_viewing_a_missing_occurrence_404s(): void
    {
        $this->actingAsUser();

        $this->get('/occurrence/999')->assertNotFound();
    }

    public function test_non_admin_cannot_view_the_edit_form(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $this->get("/occurrence/{$occurrence->id}/update")->assertForbidden();
    }

    public function test_admin_can_view_the_edit_form(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();

        $this->get("/occurrence/{$occurrence->id}/update")->assertOk();
    }

    public function test_non_admin_cannot_update_an_occurrence(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $response = $this->put("/occurrence/{$occurrence->id}/update", $this->validPayload());

        $response->assertForbidden();
    }

    public function test_admin_can_update_an_occurrence(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();

        $response = $this->put("/occurrence/{$occurrence->id}/update", [
            ...$this->validPayload(),
            'requester' => 'Novo Solicitante',
        ]);

        $response->assertRedirect(route('show-occurrence', $occurrence->id));
        $this->assertSame('Novo Solicitante', $occurrence->fresh()->requester);
    }

    public function test_updating_a_missing_occurrence_404s(): void
    {
        $this->actingAsAdmin();

        $response = $this->put('/occurrence/999/update', $this->validPayload());

        $response->assertNotFound();
    }

    public function test_non_admin_cannot_delete_an_occurrence(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $this->delete("/occurrence/{$occurrence->id}")->assertForbidden();
    }

    public function test_admin_can_delete_an_occurrence_and_its_relations(): void
    {
        $this->actingAsAdmin();
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);
        $protection = Fireprotection::factory()->create();
        $occurrence->fireprotections()->attach($protection);

        $response = $this->delete("/occurrence/{$occurrence->id}");

        $response->assertRedirect(route('index-occurrence'));
        $this->assertDatabaseMissing('occurrences', ['id' => $occurrence->id]);
        $this->assertDatabaseMissing('victims', ['id' => $victim->id]);
        $this->assertDatabaseMissing('resources', ['id' => $resource->id]);
        $this->assertDatabaseMissing('occurrence-fireprotection', ['occurrence_id' => $occurrence->id]);
    }

    public function test_deleting_a_missing_occurrence_404s(): void
    {
        $this->actingAsAdmin();

        $this->delete('/occurrence/999')->assertNotFound();
    }

    public function test_any_authenticated_user_can_download_the_pdf(): void
    {
        $this->actingAsUser();
        $occurrence = Occurrence::factory()->create();

        $response = $this->get("/occurrence/{$occurrence->id}/pdf");

        $response->assertOk();

        foreach (glob(storage_path('app/occurrence-' . $occurrence->id . '-*.html')) ?: [] as $leftover) {
            @unlink($leftover);
        }
    }
}
