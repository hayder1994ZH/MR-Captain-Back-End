<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'image', 'url', 'phone', 'type', 'is_active', 'subtitle', 'gender', 'country_id', 'city_id', 'user_id', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'user', 'country', 'city'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'country_id' => 'integer',
        'city_id' => 'integer',
    ];

    //relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
