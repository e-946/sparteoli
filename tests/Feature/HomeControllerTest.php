<?php

namespace Tests\Feature;

use App\Models\Nature;
use App\Models\Occurrence;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/home');

        $this->assertRedirectsToLogin($response);
    }

    public function test_authenticated_user_sees_the_dashboard(): void
    {
        $this->actingAsUser();

        $response = $this->get('/home');

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page->component('Dashboard', shouldExist: false));
    }

    public function test_dashboard_groups_occurrences_by_month_and_neighborhood(): void
    {
        $this->actingAsUser();

        $nature = Nature::factory()->create();
        $type = Type::factory()->create(['nature_id' => $nature->id]);

        Occurrence::factory()->count(2)->create([
            'type_id' => $type->id,
            'date' => '2026-01-15',
            'neighborhood' => 'centro',
            'city' => 'Belo Horizonte',
            'state' => 'MG',
        ]);

        Occurrence::factory()->create([
            'type_id' => $type->id,
            'date' => '2026-02-10',
            'neighborhood' => 'centro',
            'city' => 'Belo Horizonte',
            'state' => 'MG',
        ]);

        // Outside the 15 month window, should not be counted.
        Occurrence::factory()->create([
            'type_id' => $type->id,
            'date' => now()->subMonths(20)->format('Y-m-d'),
        ]);

        $response = $this->get('/home');

        $response->assertOk();
        $page = json_decode(json_encode($response->viewData('page')), true);
        $props = $page['props'];

        $months = collect($props['months'])->keyBy('name');
        $this->assertSame(2, $months['01/2026']['total']);
        $this->assertSame(1, $months['02/2026']['total']);

        $bairros = collect($props['bairros'])->keyBy('name');
        $this->assertSame(3, $bairros['Centro / Belo Horizonte-Mg']['total']);

        $natureRow = collect($props['natures'])->firstWhere('name', $nature->name);
        $this->assertSame(4, $natureRow['occurrences_count']);

        $typeRow = collect($props['types'])->firstWhere('name', $type->name);
        $this->assertSame(4, $typeRow['occurrences_count']);
    }
}
