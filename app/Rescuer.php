<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $all)
 * @method static find(int $id)
 */
class Rescuer extends Model
{
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    public function victims()
    {
        return $this->hasMany(Victim::class);
    }
}
