<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rescuer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    public function victims(): HasMany
    {
        return $this->hasMany(Victim::class);
    }
}
