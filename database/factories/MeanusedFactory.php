<?php

namespace Database\Factories;

use App\Models\Meanused;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Meanused>
 */
class MeanusedFactory extends Factory
{
    protected $model = Meanused::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
        ];
    }
}
