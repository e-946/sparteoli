<?php

namespace Database\Factories;

use App\Models\Rescuer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rescuer>
 */
class RescuerFactory extends Factory
{
    protected $model = Rescuer::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
        ];
    }
}
