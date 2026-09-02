<?php

namespace Database\Factories;

use App\Models\Nature;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Type>
 */
class TypeFactory extends Factory
{
    protected $model = Type::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'desc' => $this->faker->sentence(),
            'nature_id' => Nature::factory(),
        ];
    }
}
