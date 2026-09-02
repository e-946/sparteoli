<?php

namespace Tests\Unit\Models;

use App\Models\Occurrence;
use App\Models\Problem;
use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VictimTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $victim = Victim::factory()->create(['name' => 'MARIA DA SILVA']);

        $this->assertSame('Maria da silva', $victim->name);
    }

    public function test_sex_is_ucfirst_lowercased_on_set(): void
    {
        $victim = Victim::factory()->create(['sex' => 'f']);

        $this->assertSame('F', $victim->sex);
    }

    public function test_fatal_and_conscious_are_cast_to_boolean(): void
    {
        $victim = Victim::factory()->create(['fatal' => 1, 'conscious' => 0]);

        $this->assertTrue($victim->fatal);
        $this->assertFalse($victim->conscious);
        $this->assertIsBool($victim->fatal);
        $this->assertIsBool($victim->conscious);
    }

    public function test_victim_belongs_to_rescuer(): void
    {
        $rescuer = Rescuer::factory()->create();
        $victim = Victim::factory()->create(['rescuer_id' => $rescuer->id]);

        $this->assertTrue($victim->rescuer->is($rescuer));
    }

    public function test_victim_belongs_to_occurrence(): void
    {
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->assertTrue($victim->occurrence->is($occurrence));
    }

    public function test_victim_belongs_to_many_problems(): void
    {
        $victim = Victim::factory()->create();
        $problem = Problem::factory()->create();

        $victim->problems()->attach($problem);

        $this->assertTrue($victim->problems->contains($problem));
    }
}
