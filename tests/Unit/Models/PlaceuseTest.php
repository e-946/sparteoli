<?php

namespace Tests\Unit\Models;

use App\Models\Occurrence;
use App\Models\Placeuse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlaceuseTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $use = Placeuse::factory()->create(['name' => 'RESIDENCIAL']);

        $this->assertSame('Residencial', $use->name);
    }

    public function test_placeuse_has_many_occurrences(): void
    {
        $use = Placeuse::factory()->create();
        $occurrence = Occurrence::factory()->create(['placeuse_id' => $use->id]);

        $this->assertTrue($use->occurrences->contains($occurrence));
    }
}
