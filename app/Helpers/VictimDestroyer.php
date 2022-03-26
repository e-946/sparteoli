<?php

namespace App\Helpers;

use App\Models\Victim;

class VictimDestroyer
{

    public function __construct(int $id)
    {
        $victim = Victim::find($id);
        $this->destroy($victim);
    }

    private function destroy($victim)
    {
        $victim->problems()->detach();
        $victim->delete();
    }
}
