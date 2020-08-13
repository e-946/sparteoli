<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static find(int $id)
 */
class Resource extends Model
{
    protected $guarded = [];

    public function setWhoAttribute($value)
    {
        $this->attributes['who'] = strtoupper(mb_strtolower($value));
    }

    public function setWhereAttribute($value)
    {
        $this->attributes['where'] = ucfirst(mb_strtolower($value));
    }

    public function setHowAttribute($value)
    {
        $this->attributes['how'] = ucfirst(mb_strtolower($value));
    }

    public function setWhatAttribute($value)
    {
        $this->attributes['what'] = ucfirst(mb_strtolower($value));
    }

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class);
    }
}
