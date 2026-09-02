<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function nature(): BelongsTo
    {
        return $this->belongsTo(Nature::class);
    }

    public function occurrences(): HasMany
    {
        return $this->hasMany(Occurrence::class);
    }

    protected function setNameAttribute(mixed $value): void
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    protected function setDescAttribute(mixed $value): void
    {
        $this->attributes['desc'] = ucfirst(mb_strtolower($value));
    }
}
