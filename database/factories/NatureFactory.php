<?php

namespace Database\Factories;

use App\Models\Nature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Nature>
 */
class NatureFactory extends Factory
{
    protected $model = Nature::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'desc' => $this->faker->sentence(),
        ];
    }
}
