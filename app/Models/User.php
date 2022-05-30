<?php

namespace App\Models;

use App\Helpers\Utilities;
use App\Models\RelationshipsTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, RelationshipsTrait, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'phone',
        'password',
        'image',
        'status',
        'country',
        'city',
        'gender',
        'birth_date',
        'rule_id',
        'gym_id',
        'created_at',
        'updated_at'
    ];
    protected $relations = [
        'gym', 'rule'
    ];
    protected $hidden = [
        'password',
        'image',
        'remember_token',
        'email_verified_at',
    ];
    protected $casts = [
        'rule_id' => 'int',
        'gym_id' => 'int',
        'status' => 'boolean',
        'birth_date' => 'datetime',
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
       'image_url' 
    ];
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('public') . $this->image : null;
    }

    //Relations
    public function gym()
    {
        return $this->belongsTo(Gym::class);
    }
    public function rule()
    {
        return $this->belongsTo(Rules::class);
    }
}
