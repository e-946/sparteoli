<?php

namespace Database\Factories;

use App\Models\Meanused;
use App\Models\Occurrence;
use App\Models\Placefreature;
use App\Models\Placeuse;
use App\Models\Type;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Occurrence>
 */
class OccurrenceFactory extends Factory
{
    protected $model = Occurrence::class;

    public function definition(): array
    {
        return [
            'date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'call_time' => '08:00:00',
            'arrival_time' => '08:15:00',
            'end_time' => '09:00:00',
            'meanused_id' => Meanused::factory(),
            'zip_code' => $this->faker->postcode(),
            'address' => $this->faker->streetAddress(),
            'neighborhood' => $this->faker->citySuffix(),
            'city' => $this->faker->city(),
            'state' => strtoupper($this->faker->lexify('??')),
            'requester' => $this->faker->name(),
            'requester_phone' => $this->faker->numerify('###########'),
            'resume' => $this->faker->paragraph(),
            'placefreature_id' => Placefreature::factory(),
            'placeuse_id' => Placeuse::factory(),
            'place_preservation' => $this->faker->boolean(),
            'filler_name' => $this->faker->name(),
            'filler_register' => $this->faker->numerify('##########'),
            'filler_patent' => $this->faker->word(),
            'type_id' => Type::factory(),
            'user_id' => User::factory(),
        ];
    }
}
