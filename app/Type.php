<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $id)
 */
class Type extends Model
{
    protected $guarded = [];

    public function nature()
    {
        return $this->belongsTo(Nature::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }
}
