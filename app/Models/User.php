<?php

namespace App\Models;

use App\Helpers\Utilities;
use App\Models\RelationshipsTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, RelationshipsTrait, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'image',
        'long', 
        'lat', 
        'notes',
        'include_player_ids',
        'email_verified_at',
        'remember_token',
        'birthday',
        'gender',
        'card_number',
        'rule_id',
        'gym_id',
        'city_id',
        'status',
        'created_at',
        'updated_at'
    ];
    protected $relations = [
        'rule', 'gym', 'city', 'city.country'
    ];
    protected $hidden = [
        'password',
        'image',
        'remember_token',
        'email_verified_at',
        'deleted_at',
    ];
    protected $casts = [
        'city_id' => 'int',
        'rule_id' => 'int',
        'status' => 'boolean',
        'email_verified_at' => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $appends = [
       'image_url',
    ];
    public function getImageUrlAttribute()
    {
        return $this->image ? request()->get('host') . Utilities::$imageBucket . $this->image : null;
    }

    //Relations player_id
    public function rule()
    {
        return $this->belongsTo(Rules::class);
    }
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function debts()
    {
        return $this->hasMany(Debts::class, 'player_id');
    }
}
