<?php

namespace Database\Seeders;

use App\Models\Fireprotection;
use App\Models\Meanused;
use App\Models\Occurrence;
use App\Models\Placefreature;
use App\Models\Placeuse;
use App\Models\Problem;
use App\Models\Rescuer;
use App\Models\Resource;
use App\Models\Type;
use App\Models\User;
use App\Models\Victim;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;

class OccurrencesSeeder extends Seeder
{
    private const NEIGHBORHOODS = [
        ['neighborhood' => 'Pituba', 'city' => 'Salvador', 'state' => 'BA'],
        ['neighborhood' => 'Barra', 'city' => 'Salvador', 'state' => 'BA'],
        ['neighborhood' => 'Itapuã', 'city' => 'Salvador', 'state' => 'BA'],
        ['neighborhood' => 'Cabula', 'city' => 'Salvador', 'state' => 'BA'],
        ['neighborhood' => 'Piatã', 'city' => 'Salvador', 'state' => 'BA'],
        ['neighborhood' => 'Centro', 'city' => 'Lauro de Freitas', 'state' => 'BA'],
        ['neighborhood' => 'Portão', 'city' => 'Lauro de Freitas', 'state' => 'BA'],
        ['neighborhood' => 'Centro', 'city' => 'Simões Filho', 'state' => 'BA'],
    ];

    private const FILLERS = [
        ['filler_name' => 'Carlos Eduardo Santos', 'filler_register' => '1122334455', 'filler_patent' => 'Sargento'],
        ['filler_name' => 'Marcos Vinícius Lima', 'filler_register' => '2233445566', 'filler_patent' => 'Cabo'],
        ['filler_name' => 'Ana Paula Ribeiro', 'filler_register' => '3344556677', 'filler_patent' => 'Tenente'],
    ];

    private const RESOURCE_WHO = ['Equipe Alfa', 'Equipe Bravo', 'Equipe Charlie', 'Viatura ABTR', 'Ambulância'];

    private const RESOURCE_WHERE = ['Térreo', 'Andar superior', 'Área externa', 'Garagem'];

    private const RESOURCE_HOW = ['Via escada', 'Via janela', 'Porta principal', 'Acesso lateral'];

    private const RESOURCE_WHAT = ['Extintor', 'Corda', 'Maca', 'Motosserra', 'Escada'];

    public function run(): void
    {
        $meanuseds = Meanused::all();
        $types = Type::all();
        $placefreatures = Placefreature::all();
        $placeuses = Placeuse::all();
        $fireprotections = Fireprotection::all();
        $rescuers = Rescuer::all();
        $problems = Problem::all();
        $users = User::all();

        for ($i = 0; $i < 90; $i++) {
            $location = fake()->randomElement(self::NEIGHBORHOODS);
            $filler = fake()->randomElement(self::FILLERS);
            $callTime = fake()->time('H:i:s');

            $occurrence = Occurrence::create([
                'date' => Carbon::now()->subDays(fake()->numberBetween(0, 450))->format('Y-m-d'),
                'call_time' => $callTime,
                'arrival_time' => Carbon::createFromFormat('H:i:s', $callTime)
                    ->addMinutes(fake()->numberBetween(5, 25))->format('H:i:s'),
                'end_time' => Carbon::createFromFormat('H:i:s', $callTime)
                    ->addMinutes(fake()->numberBetween(30, 180))->format('H:i:s'),
                'meanused_id' => $meanuseds->random()->id,
                'zip_code' => fake()->numerify('########'),
                'address' => fake()->streetName() . ', Nº ' . fake()->buildingNumber(),
                'neighborhood' => $location['neighborhood'],
                'city' => $location['city'],
                'state' => $location['state'],
                'requester' => fake()->name(),
                'requester_phone' => '719' . fake()->numerify('########'),
                'resume' => fake()->paragraph(4),
                'placefreature_id' => $placefreatures->random()->id,
                'placeuse_id' => $placeuses->random()->id,
                'place_preservation' => fake()->boolean(70),
                'filler_name' => $filler['filler_name'],
                'filler_register' => $filler['filler_register'],
                'filler_patent' => $filler['filler_patent'],
                'type_id' => $types->random()->id,
                'user_id' => $users->isNotEmpty() ? $users->random()->id : null,
            ]);

            if ($fireprotections->isNotEmpty() && fake()->boolean(50)) {
                $occurrence->fireprotections()->attach(
                    $fireprotections->random(fake()->numberBetween(1, min(3, $fireprotections->count())))->pluck('id')
                );
            }

            $this->createVictims($occurrence, $rescuers, $problems);
            $this->createResources($occurrence);
        }
    }

    /**
     * @param  Collection<int, Rescuer>  $rescuers
     * @param  Collection<int, Problem>  $problems
     */
    private function createVictims(Occurrence $occurrence, Collection $rescuers, Collection $problems): void
    {
        if ($rescuers->isEmpty()) {
            return;
        }

        $victimCount = fake()->numberBetween(0, 4);

        for ($v = 0; $v < $victimCount; $v++) {
            $victim = Victim::create([
                'name' => fake()->name(),
                'age' => fake()->numberBetween(1, 90),
                'sex' => fake()->randomElement(['M', 'F']),
                'conscious' => fake()->boolean(80),
                'fatal' => fake()->boolean(10),
                'rescuer_id' => $rescuers->random()->id,
                'occurrence_id' => $occurrence->id,
            ]);

            if ($problems->isNotEmpty()) {
                $victim->problems()->attach(
                    $problems->random(fake()->numberBetween(0, min(2, $problems->count())))->pluck('id')
                );
            }
        }
    }

    private function createResources(Occurrence $occurrence): void
    {
        $resourceCount = fake()->numberBetween(0, 3);

        for ($r = 0; $r < $resourceCount; $r++) {
            Resource::create([
                'who' => fake()->randomElement(self::RESOURCE_WHO),
                'where' => fake()->randomElement(self::RESOURCE_WHERE),
                'how' => fake()->randomElement(self::RESOURCE_HOW),
                'what' => fake()->randomElement(self::RESOURCE_WHAT),
                'occurrence_id' => $occurrence->id,
            ]);
        }
    }
}
