<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Placeuse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function occurrences(): HasMany
    {
        return $this->hasMany(Occurrence::class);
    }

    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }
}
