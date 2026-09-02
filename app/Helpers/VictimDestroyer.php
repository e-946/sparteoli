<?php

namespace App\Helpers;

use App\Models\Victim;

class VictimDestroyer
{
    public function __construct(int $id)
    {
        $victim = Victim::findOrFail($id);
        $this->destroy($victim);
    }

    private function destroy(Victim $victim): void
    {
        $victim->problems()->detach();
        $victim->delete();
    }
}
