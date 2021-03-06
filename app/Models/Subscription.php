<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'is_active', 'is_sms', 'is_whatsapp', 'player_id', 'gym_id', 'card_id', 'start_date', 'expair_date', 'created_at', 'updated_at'
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
        'start_date' => 'datetime',
    ];
    protected $appends = [
        'number_of_days',
    ];
    public function getNumberOfDaysAttribute()
    {
        $start = new \DateTime($this->start_date);
        $end = new \DateTime($this->expair_date);
        $interval = $start->diff($end);
        return $interval->format('%a');
    }

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
