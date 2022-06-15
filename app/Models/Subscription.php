<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'is_active', 'is_sms', 'is_whatsapp', 'player_id', 'gym_id', 'card_id', 'expair_date', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'player', 'gym', 'card'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'player_id' => 'integer',
        'card_id' => 'integer',
        'gym_id' => 'string',
        'is_active' => 'boolean',
        'is_sms' => 'boolean',
        'is_whatsapp' => 'boolean',
        'expair_date' => 'datetime',
    ];

    //relationships
    public function player()
    {
        return $this->belongsTo(User::class, 'player_id');
    }
    public function card()
    {
        return $this->belongsTo(Cards::class);
    }
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid');
    }
}
