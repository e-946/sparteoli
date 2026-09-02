<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Problem extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function setNameAttribute(mixed $value): void
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    protected function setDescAttribute(mixed $value): void
    {
        $this->attributes['desc'] = ucfirst(mb_strtolower($value));
    }

    public function victims(): BelongsToMany
    {
        return $this->belongsToMany(Victim::class, 'victims-problems', 'problem_id', 'victim_id');
    }
}
