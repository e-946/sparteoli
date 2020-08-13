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

    public function occurrences()
    {
        return $this->belongsToMany(Occurrence::class, 'occurrence-fireprotection', 'fireprotection_id', 'occurrence_id');
    }
}
