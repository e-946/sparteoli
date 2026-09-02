<?php

namespace Database\Factories;

use App\Models\Placefreature;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Placefreature>
 */
class PlacefreatureFactory extends Factory
{
    protected $model = Placefreature::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
        ];
    }
}
