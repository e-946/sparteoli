<?php

namespace Tests\Unit\Helpers;

use App\Helpers\VictimDestroyer;
use App\Models\Problem;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class VictimDestroyerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_deletes_the_victim(): void
    {
        $victim = Victim::factory()->create();

        new VictimDestroyer($victim->id);

        $this->assertDatabaseMissing('victims', ['id' => $victim->id]);
    }

    public function test_it_detaches_the_victims_problems(): void
    {
        $victim = Victim::factory()->create();
        $problem = Problem::factory()->create();
        $victim->problems()->attach($problem);

        new VictimDestroyer($victim->id);

        $this->assertDatabaseMissing('victims-problems', ['victim_id' => $victim->id]);
    }
}
