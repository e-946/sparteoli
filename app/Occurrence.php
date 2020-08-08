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

    public function victims()
    {
        return $this->hasMany(Victim::class);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = ucfirst(mb_strtolower($value));
    }
    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = ucfirst(mb_strtolower($value));
    }
    public function setCityAttribute($value)
    {
        $this->attributes['city'] = ucfirst(mb_strtolower($value));
    }
    public function setStateAttribute($value)
    {
        $this->attributes['state'] = ucfirst(mb_strtolower($value));
    }
    public function setRequesterAttribute($value)
    {
        $this->attributes['requester'] = ucfirst(mb_strtolower($value));
    }
    public function setFillerNameAttribute($value)
    {
        $this->attributes['filler_name'] = ucfirst(mb_strtolower($value));
    }
    public function setFillerPatentAttribute($value)
    {
        $this->attributes['filler_patent'] = ucfirst(mb_strtolower($value));
    }
}
