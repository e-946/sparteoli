<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create()
 * @method static find(int $id)
 */
class Victim extends Model
{
    protected $guarded = [];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst(mb_strtolower($value));
    }

    public function setSexAttribute($value)
    {
        $this->attributes['sex'] = ucfirst(mb_strtolower($value));
    }

    public function rescuer()
    {
        return $this->belongsTo(Rescuer::class);
    }

    public function problems()
    {
        return $this->belongsToMany(Problem::class, 'victims-problems', 'victim_id', 'problem_id');
    }

    public function occurrence()
    {
        return $this->belongsTo(Occurrence::class);
    }
}
