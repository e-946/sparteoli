<?php

namespace Database\Factories;

use App\Models\Occurrence;
use App\Models\Rescuer;
use App\Models\Victim;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Victim>
 */
class VictimFactory extends Factory
{
    protected $model = Victim::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'age' => $this->faker->numberBetween(0, 100),
            'sex' => $this->faker->randomElement(['M', 'F']),
            'conscious' => $this->faker->boolean(),
            'fatal' => false,
            'rescuer_id' => Rescuer::factory(),
            'occurrence_id' => Occurrence::factory(),
        ];
    }
}
