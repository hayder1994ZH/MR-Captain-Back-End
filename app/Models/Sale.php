<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'details', 'price', 'user_id', 'gym_id', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'captain', 'gym'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'user_id' => 'integer',
    ];

    //relationships
    public function captain()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid');
    }
}
