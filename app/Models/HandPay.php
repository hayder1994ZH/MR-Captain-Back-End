<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HandPay extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'details', 'old_price', 'current_price', 'price', 'user_id', 'gym_id', 'player_id', 'debt_id', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'captain', 'gym', 'player', 'debt'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'player_id' => 'integer',
    ];

    //relationships
    public function captain()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
    public function debt()
    {
        return $this->belongsTo(Debts::class, 'debt_id');
    }
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid');
    }
}
