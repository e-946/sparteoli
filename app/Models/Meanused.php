<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static find(int $id)
 */
class Meanused extends Model
{
    protected $guarded = [];

    public function occurrences()
    {
        return $this->hasMany(Occurrence::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }
}
