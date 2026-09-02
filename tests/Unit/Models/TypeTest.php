<?php

namespace Tests\Unit\Models;

use App\Models\Nature;
use App\Models\Occurrence;
use App\Models\Type;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $type = Type::factory()->create(['name' => 'CURTO CIRCUITO']);

        $this->assertSame('Curto circuito', $type->name);
    }

    public function test_desc_is_ucfirst_lowercased_on_set(): void
    {
        $type = Type::factory()->create(['desc' => 'ALGUMA DESCRIÇÃO']);

        $this->assertSame('Alguma descrição', $type->desc);
    }

    public function test_type_belongs_to_nature(): void
    {
        $nature = Nature::factory()->create();
        $type = Type::factory()->create(['nature_id' => $nature->id]);

        $this->assertTrue($type->nature->is($nature));
    }

    public function test_type_has_many_occurrences(): void
    {
        $type = Type::factory()->create();
        $occurrence = Occurrence::factory()->create(['type_id' => $type->id]);

        $this->assertTrue($type->occurrences->contains($occurrence));
    }
}
