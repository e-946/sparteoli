<?php

namespace Database\Factories;

use App\Models\Fireprotection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fireprotection>
 */
class FireprotectionFactory extends Factory
{
    protected $model = Fireprotection::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'desc' => $this->faker->sentence(),
        ];
    }
}
