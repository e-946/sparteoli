<?php

namespace Database\Factories;

use App\Models\Occurrence;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    protected $model = Resource::class;

    public function definition(): array
    {
        return [
            'who' => $this->faker->word(),
            'where' => $this->faker->word(),
            'how' => $this->faker->word(),
            'what' => $this->faker->word(),
            'occurrence_id' => Occurrence::factory(),
        ];
    }
}
