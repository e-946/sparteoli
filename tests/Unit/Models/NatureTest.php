<?php

namespace Tests\Unit\Models;

use App\Models\Nature;
use App\Models\Occurrence;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $nature = Nature::factory()->create(['name' => 'INCÊNDIO URBANO']);

        $this->assertSame('Incêndio urbano', $nature->name);
    }

    public function test_desc_is_ucfirst_lowercased_on_set(): void
    {
        $nature = Nature::factory()->create(['desc' => 'ALGUMA DESCRIÇÃO']);

        $this->assertSame('Alguma descrição', $nature->desc);
    }

    public function test_nature_has_many_types(): void
    {
        $nature = Nature::factory()->create();
        $type = Type::factory()->create(['nature_id' => $nature->id]);

        $this->assertTrue($nature->types->contains($type));
    }

    public function test_nature_has_many_occurrences_through_type(): void
    {
        $nature = Nature::factory()->create();
        $type = Type::factory()->create(['nature_id' => $nature->id]);
        $occurrence = Occurrence::factory()->create(['type_id' => $type->id]);

        $this->assertTrue($nature->occurrences->contains($occurrence));
    }
}
