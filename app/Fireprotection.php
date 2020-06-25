<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fireprotection extends Model
{
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }
}
