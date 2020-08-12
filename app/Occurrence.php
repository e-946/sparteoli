<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $data)
 * @method static find(int $id)
 */
class Occurrence extends Model
{
    protected $guarded = [];

    public function meanused()
    {
        return $this->belongsTo(Meanused::class);
    }

    public function placefreature()
    {
        return $this->belongsTo(Placefreature::class);
    }

    public function placeuse()
    {
        return $this->belongsTo(Placeuse::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function victims()
    {
        return $this->hasMany(Victim::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
