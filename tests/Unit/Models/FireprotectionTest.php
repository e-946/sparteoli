<?php

namespace Tests\Unit\Models;

use App\Models\Fireprotection;
use App\Models\Occurrence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FireprotectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $protection = Fireprotection::factory()->create(['name' => 'EXTINTOR ABC']);

        $this->assertSame('Extintor abc', $protection->name);
    }

    public function test_fireprotection_belongs_to_many_occurrences(): void
    {
        $protection = Fireprotection::factory()->create();
        $occurrence = Occurrence::factory()->create();

        $occurrence->fireprotections()->attach($protection);

        $this->assertTrue($protection->occurrences->contains($occurrence));
    }
}
