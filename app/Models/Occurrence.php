<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occurrence extends Model
{
    protected $guarded = [];

    public function meanused(): BelongsTo
    {
        return $this->belongsTo(Meanused::class);
    }

    public function placefreature(): BelongsTo
    {
        return $this->belongsTo(Placefreature::class);
    }

    public function placeuse(): BelongsTo
    {
        return $this->belongsTo(Placeuse::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function fireprotections(): BelongsToMany
    {
        return $this->belongsToMany(
            Fireprotection::class,
            'occurrence-fireprotection',
            'occurrence_id',
            'fireprotection_id'
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function victims(): HasMany
    {
        return $this->hasMany(Victim::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }


    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucwords(mb_strtolower($value));
    }
    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = ucwords(mb_strtolower($value));
    }
    public function setCityAttribute($value)
    {
        $this->attributes['city'] = ucwords(mb_strtolower($value));
    }
    public function setStateAttribute($value)
    {
        $this->attributes['state'] = ucwords(mb_strtolower($value));
    }
    public function setRequesterAttribute($value)
    {
        $this->attributes['requester'] = ucwords(mb_strtolower($value));
    }
    public function setFillerNameAttribute($value)
    {
        $this->attributes['filler_name'] = ucwords(mb_strtolower($value));
    }
    public function setFillerPatentAttribute($value)
    {
        $this->attributes['filler_patent'] = ucfirst(mb_strtolower($value));
    }
}
