<?php

namespace Tests\Unit\Models;

use App\Models\Occurrence;
use App\Models\Resource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ResourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_who_is_uppercased_on_set(): void
    {
        $resource = Resource::factory()->create(['who' => 'equipe alfa']);

        $this->assertSame('EQUIPE ALFA', $resource->who);
    }

    public function test_where_how_and_what_are_ucfirst_lowercased_on_set(): void
    {
        $resource = Resource::factory()->create([
            'where' => 'SALA DE ESTAR',
            'how' => 'PELA JANELA',
            'what' => 'MOTOSSERRA',
        ]);

        $this->assertSame('Sala de estar', $resource->where);
        $this->assertSame('Pela janela', $resource->how);
        $this->assertSame('Motosserra', $resource->what);
    }

    public function test_resource_belongs_to_occurrence(): void
    {
        $occurrence = Occurrence::factory()->create();
        $resource = Resource::factory()->create(['occurrence_id' => $occurrence->id]);

        $this->assertTrue($resource->occurrence->is($occurrence));
    }
}
