<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    protected $guarded = [];

    public function nature(): BelongsTo
    {
        return $this->belongsTo(Nature::class);
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(Occurrence::class);
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
