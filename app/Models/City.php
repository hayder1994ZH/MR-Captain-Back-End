<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'country_id', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'country'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'country_id' => 'int',
    ];

    //Relations
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
