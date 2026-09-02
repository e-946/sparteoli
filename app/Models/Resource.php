<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resource extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function setWhoAttribute($value)
    {
        $this->attributes['who'] = strtoupper(mb_strtolower($value));
    }

    protected function setWhereAttribute($value)
    {
        $this->attributes['where'] = ucfirst(mb_strtolower($value));
    }

    protected function setHowAttribute($value)
    {
        $this->attributes['how'] = ucfirst(mb_strtolower($value));
    }

    protected function setWhatAttribute($value)
    {
        $this->attributes['what'] = ucfirst(mb_strtolower($value));
    }

    public function occurrence(): BelongsTo
    {
        return $this->belongsTo(Occurrence::class);
    }
}
