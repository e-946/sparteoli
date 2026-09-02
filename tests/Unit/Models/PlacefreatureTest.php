<?php

namespace Tests\Unit\Models;

use App\Models\Occurrence;
use App\Models\Placefreature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlacefreatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $freature = Placefreature::factory()->create(['name' => 'ZONA RURAL']);

        $this->assertSame('Zona rural', $freature->name);
    }

    public function test_placefreature_has_many_occurrences(): void
    {
        $freature = Placefreature::factory()->create();
        $occurrence = Occurrence::factory()->create(['placefreature_id' => $freature->id]);

        $this->assertTrue($freature->occurrences->contains($occurrence));
    }
}
