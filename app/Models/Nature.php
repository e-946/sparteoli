<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Nature extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function types(): HasMany
    {
        return $this->hasMany(Type::class);
    }

    public function occurrences(): HasManyThrough
    {
        return $this->hasManyThrough(Occurrence::class, Type::class);
    }

    protected function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    protected function setDescAttribute($value)
    {
        $this->attributes['desc'] = ucfirst(mb_strtolower($value));
    }
}
