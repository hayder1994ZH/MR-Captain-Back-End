<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'title', 'details', 'weight', 'price', 'captain_id', 'gym_id', 'player_id', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'captain', 'gym', 'player', 'handPay'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'captain_id' => 'integer',
        'player_id' => 'integer',
    ];

    //relationships
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id')->select('id', 'name', 'phone', 'image');
    }
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id')->select('id', 'name', 'phone', 'image');
    }
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid')->select('uuid', 'name', 'logo');
    }
}
