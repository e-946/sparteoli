<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method create()
 * @method static findAll()
 * @method static find(int $id)
 */
class Nature extends Model
{
    protected $guarded = [];

    public function types()
    {
        return $this->hasMany(Type::class);
    }

    public function occurrences()
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
