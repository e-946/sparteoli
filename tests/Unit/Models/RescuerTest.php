<?php

namespace Tests\Unit\Models;

use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RescuerTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_ucfirst_lowercased_on_set(): void
    {
        $rescuer = Rescuer::factory()->create(['name' => 'CORPO DE BOMBEIROS']);

        $this->assertSame('Corpo de bombeiros', $rescuer->name);
    }

    public function test_rescuer_has_many_victims(): void
    {
        $rescuer = Rescuer::factory()->create();
        $victim = Victim::factory()->create(['rescuer_id' => $rescuer->id]);

        $this->assertTrue($rescuer->victims->contains($victim));
    }
}
