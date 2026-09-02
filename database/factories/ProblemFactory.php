<?php

namespace Database\Factories;

use App\Models\Problem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Problem>
 */
class ProblemFactory extends Factory
{
    protected $model = Problem::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'desc' => $this->faker->sentence(),
        ];
    }
}
