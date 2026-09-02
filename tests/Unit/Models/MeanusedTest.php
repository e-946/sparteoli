<?php

namespace Tests\Unit\Models;

use App\Models\Meanused;
use App\Models\Occurrence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MeanusedTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $mean = Meanused::factory()->create(['name' => 'TELEFONE']);

        $this->assertSame('Telefone', $mean->name);
    }

    public function test_meanused_has_many_occurrences(): void
    {
        $mean = Meanused::factory()->create();
        $occurrence = Occurrence::factory()->create(['meanused_id' => $mean->id]);

        $this->assertTrue($mean->occurrences->contains($occurrence));
    }
}
