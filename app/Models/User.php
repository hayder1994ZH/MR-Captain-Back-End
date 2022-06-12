<?php

namespace App\Models;

use App\Helpers\Utilities;
use App\Models\RelationshipsTrait;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, RelationshipsTrait;

    protected $fillable = [
        'id',
        'name',
        'username',
        'phone',
        'password',
        'image',
        'rule_id',
        'created_at',
        'updated_at'
    ];
    protected $relations = [
        'reels', 'rule', 'followers', 'followings'
    ];
    protected $hidden = [
        'password',
        'image',
        'is_deleted',
        'remember_token',
        'email_verified_at',
    ];
    protected $casts = [
        'reel_id' => 'int',
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
         'is_followed'
    ];
    public function getImageUrlAttribute()
    {
        return $this->image ? request()->get('host') . Utilities::$imageBucket . $this->image : null;
    }
    public function getIsFollowedAttribute()
    {
        if(auth()->user()->id == $this->id) {
            return true;
        }
        $YouAreFollowed = Followers::where(function($query) {
            $query->where('sender_id', auth()->user()->id)
                ->where('receiver_id', $this->id)
                ->where('status', 0);
                })->orwhere(function($query) {
                    $query->where('sender_id', $this->id)
                        ->where('receiver_id', auth()->user()->id)
                        ->where('status', 0);
            })->first();
        return $YouAreFollowed ? true : false;
    }

    //Relations
    public function reels()
    {
        return $this->hasMany(Reels::class);
    }
    public function followings()
    {
        return $this->hasMany(Followers::class, 'sender_id');
    }
    public function followers()
    {
        return $this->hasMany(Followers::class, 'receiver_id');
    }
    public function rule()
    {
        return $this->belongsTo(Rules::class);
    }
}
