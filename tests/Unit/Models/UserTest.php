<?php

namespace Tests\Unit\Models;

use App\Models\Occurrence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_name_is_capitalized_on_set(): void
    {
        $user = User::factory()->create(['name' => 'joão da silva']);

        $this->assertSame('João Da Silva', $user->name);
    }

    public function test_admin_is_cast_to_boolean(): void
    {
        $user = User::factory()->create(['admin' => 1]);

        $this->assertTrue($user->admin);
        $this->assertIsBool($user->admin);
    }

    public function test_password_and_remember_token_are_hidden(): void
    {
        $user = User::factory()->create();

        $this->assertArrayNotHasKey('password', $user->toArray());
        $this->assertArrayNotHasKey('remember_token', $user->toArray());
    }

    public function test_user_has_many_occurrences(): void
    {
        $user = User::factory()->create();
        $occurrence = Occurrence::factory()->create(['user_id' => $user->id]);

        $this->assertTrue($user->occurrences->contains($occurrence));
    }
}
