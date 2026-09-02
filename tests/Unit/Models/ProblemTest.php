<?php

namespace Tests\Unit\Models;

use App\Models\Problem;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProblemTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $problem = Problem::factory()->create(['name' => 'FRATURA EXPOSTA']);

        $this->assertSame('Fratura exposta', $problem->name);
    }

    public function test_desc_is_ucfirst_lowercased_on_set(): void
    {
        $problem = Problem::factory()->create(['desc' => 'ALGUMA DESCRIÇÃO']);

        $this->assertSame('Alguma descrição', $problem->desc);
    }

    public function test_problem_belongs_to_many_victims(): void
    {
        $problem = Problem::factory()->create();
        $victim = Victim::factory()->create();

        $victim->problems()->attach($problem);

        $this->assertTrue($problem->victims->contains($victim));
    }
}
