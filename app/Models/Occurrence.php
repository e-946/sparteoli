<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Occurrence extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'place_preservation' => 'boolean',
    ];

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

    /**
     * @phpstan-return HasMany<Victim, $this>
     *
     * @psalm-return HasMany<Victim, Occurrence>
     */
    public function victims(): HasMany
    {
        return $this->hasMany(Victim::class);
    }

    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    protected function setAddressAttribute(mixed $value): void
    {
        $this->attributes['address'] = ucwords(mb_strtolower($value));
    }

    protected function setNeighborhoodAttribute(mixed $value): void
    {
        $this->attributes['neighborhood'] = ucwords(mb_strtolower($value));
    }

    protected function setCityAttribute(mixed $value): void
    {
        $this->attributes['city'] = ucwords(mb_strtolower($value));
    }

    protected function setStateAttribute(mixed $value): void
    {
        $this->attributes['state'] = ucwords(mb_strtolower($value));
    }

    protected function setRequesterAttribute(mixed $value): void
    {
        $this->attributes['requester'] = ucwords(mb_strtolower($value));
    }

    protected function setFillerNameAttribute(mixed $value): void
    {
        $this->attributes['filler_name'] = ucwords(mb_strtolower($value));
    }

    protected function setFillerPatentAttribute(mixed $value): void
    {
        $this->attributes['filler_patent'] = ucfirst(mb_strtolower($value));
    }
}
