<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(int $id)
 * @method static findById($typeId)
 * @method static create(array $all)
 */
class Type extends Model
{
    protected $guarded = [];

    public function nature()
    {
        return $this->belongsTo(Nature::class);
    }

    public function occurrences()
    {
        return $this->hasMany(Occurrence::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    public function setDescAttribute($value)
    {
        $this->attributes['desc'] = ucfirst(mb_strtolower($value));
    }
}
