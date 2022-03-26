<?php

namespace App\Helpers;

use App\Models\Victim;

class VictimCreator
{
    private string $name;
    private int $age;
    private string $sex;
    private int $fatal;
    private ?int $conscious;
    private int $rescuer_id;
    private array $problemForSave;
    private int $occurrence_id;

    public function __construct(
        string $name,
        int $age,
        string $sex,
        int $fatal,
        ?int $conscious,
        int $rescuer_id,
        array $problemForSave,
        int $occurrence_id
    ) {
        $this->name = $name;
        $this->age = $age;
        $this->sex = $sex;
        $this->fatal = $fatal;
        $this->conscious = $conscious;
        $this->rescuer_id = $rescuer_id;
        $this->problemForSave = $problemForSave;
        $this->occurrence_id = $occurrence_id;

        return $this->createVictim();
    }

    private function createVictim(): Victim
    {
        if ($this->fatal === 1) {
            $this->conscious = 0;
        }

        $victim = Victim::create([
            'name' => $this->name,
            'age' => $this->age,
            'sex' => $this->sex,
            'rescuer_id' => $this->rescuer_id,
            'fatal' => $this->fatal,
            'conscious' => $this->conscious,
            'occurrence_id' => $this->occurrence_id
        ]);

        $victim->problems()->attach($this->problemForSave);

        return $victim;
    }
}
