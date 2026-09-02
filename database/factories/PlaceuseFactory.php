<?php

namespace Database\Factories;

use App\Models\Placeuse;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Placeuse>
 */
class PlaceuseFactory extends Factory
{
    protected $model = Placeuse::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
        ];
    }
}
