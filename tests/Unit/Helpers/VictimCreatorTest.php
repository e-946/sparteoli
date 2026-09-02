<?php

namespace Tests\Unit\Helpers;

use App\Helpers\VictimCreator;
use App\Models\Occurrence;
use App\Models\Problem;
use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VictimCreatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_victim_with_the_given_attributes(): void
    {
        $occurrence = Occurrence::factory()->create();
        $rescuer = Rescuer::factory()->create();
        $problem = Problem::factory()->create();

        new VictimCreator('maria silva', 30, 'f', 0, 1, $rescuer->id, [$problem->id], $occurrence->id);

        $victim = Victim::sole();

        $this->assertSame('Maria silva', $victim->name);
        $this->assertSame(30, $victim->age);
        $this->assertSame('F', $victim->sex);
        $this->assertFalse($victim->fatal);
        $this->assertTrue($victim->conscious);
        $this->assertTrue($victim->rescuer->is($rescuer));
        $this->assertTrue($victim->occurrence->is($occurrence));
    }

    public function test_it_attaches_the_given_problems(): void
    {
        $occurrence = Occurrence::factory()->create();
        $rescuer = Rescuer::factory()->create();
        $problems = Problem::factory()->count(2)->create();

        new VictimCreator('maria silva', 30, 'f', 0, 1, $rescuer->id, $problems->pluck('id')->all(), $occurrence->id);

        $victim = Victim::sole();

        $this->assertCount(2, $victim->problems);
    }

    public function test_conscious_is_forced_to_zero_when_victim_is_fatal(): void
    {
        $occurrence = Occurrence::factory()->create();
        $rescuer = Rescuer::factory()->create();
        $problem = Problem::factory()->create();

        new VictimCreator('maria silva', 30, 'f', 1, 1, $rescuer->id, [$problem->id], $occurrence->id);

        $victim = Victim::sole();

        $this->assertTrue($victim->fatal);
        $this->assertFalse($victim->conscious);
    }
}
