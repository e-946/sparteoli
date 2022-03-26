<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Nature extends Model
{
    protected $guarded = [];

    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }

    public function occurrences(): HasManyThrough
    {
        return $this->hasManyThrough(Occurrence::class, Type::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    public function setDescAttribute($value)
    {
        $this->attributes['desc'] = ucfirst(mb_strtolower($value));
    }
}
