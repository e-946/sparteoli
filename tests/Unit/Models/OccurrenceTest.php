<?php

namespace Tests\Unit\Models;

use App\Models\Fireprotection;
use App\Models\Meanused;
use App\Models\Occurrence;
use App\Models\Placefreature;
use App\Models\Placeuse;
use App\Models\Resource;
use App\Models\Type;
use App\Models\User;
use App\Models\Victim;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OccurrenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_place_preservation_is_cast_to_boolean(): void
    {
        $occurrence = Occurrence::factory()->create(['place_preservation' => 1]);

        $this->assertTrue($occurrence->place_preservation);
        $this->assertIsBool($occurrence->place_preservation);
    }

    public function test_address_neighborhood_city_state_requester_are_ucwords_lowercased_on_set(): void
    {
        $occurrence = Occurrence::factory()->create([
            'address' => 'RUA DAS FLORES, Nº 10',
            'neighborhood' => 'CENTRO DA CIDADE',
            'city' => 'BELO HORIZONTE',
            'state' => 'MINAS GERAIS',
            'requester' => 'JOÃO DA SILVA',
        ]);

        $this->assertSame('Rua Das Flores, Nº 10', $occurrence->address);
        $this->assertSame('Centro Da Cidade', $occurrence->neighborhood);
        $this->assertSame('Belo Horizonte', $occurrence->city);
        $this->assertSame('Minas Gerais', $occurrence->state);
        $this->assertSame('João Da Silva', $occurrence->requester);
    }

    public function test_filler_name_is_ucwords_lowercased_and_filler_patent_is_ucfirst_lowercased_on_set(): void
    {
        $occurrence = Occurrence::factory()->create([
            'filler_name' => 'CARLOS EDUARDO',
            'filler_patent' => 'SARGENTO',
        ]);

        $this->assertSame('Carlos Eduardo', $occurrence->filler_name);
        $this->assertSame('Sargento', $occurrence->filler_patent);
    }

    public function test_occurrence_belongs_to_relations(): void
    {
        $meanused = Meanused::factory()->create();
        $placefreature = Placefreature::factory()->create();
        $placeuse = Placeuse::factory()->create();
        $type = Type::factory()->create();
        $user = User::factory()->create();

        $occurrence = Occurrence::factory()->create([
            'meanused_id' => $meanused->id,
            'placefreature_id' => $placefreature->id,
            'placeuse_id' => $placeuse->id,
            'type_id' => $type->id,
            'user_id' => $user->id,
        ]);

        $this->assertTrue($occurrence->meanused->is($meanused));
        $this->assertTrue($occurrence->placefreature->is($placefreature));
        $this->assertTrue($occurrence->placeuse->is($placeuse));
        $this->assertTrue($occurrence->type->is($type));
        $this->assertTrue($occurrence->user->is($user));
    }

    public function test_occurrence_belongs_to_many_fireprotections(): void
    {
        $occurrence = Occurrence::factory()->create();
        $protection = Fireprotection::factory()->create();

        $occurrence->fireprotections()->attach($protection);

        $this->assertTrue($occurrence->fireprotections->contains($protection));
    }

    public function test_occurrence_has_many_victims_and_resources(): void
    {
        $occurrence = Occurrence::factory()->create();
        $victim = Victim::factory()->create(['occurrence_id' => $occurrence->id]);
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->assertTrue($occurrence->victims->contains($victim));
        $this->assertTrue($occurrence->resources->contains($resource));
    }
}
