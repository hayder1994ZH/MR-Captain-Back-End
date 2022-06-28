<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MuscleTraining extends Model
{ 
    use SoftDeletes;
    protected $fillable = [
        'id', 'day_muscle_id', 'training_id', 'push_id', 'gym_id', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'gym', 'training', 'push', 'day_muscle'
    ];
    protected $hidden = [
        'deleted_at', 'gym_id', 'training_id', 'push_id', 'day_muscle_id', 'created_at', 'updated_at'
    ];
    protected $casts = [];

    //relationships
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid')->select('uuid', 'name', 'logo');
    }
    public function day_muscle()
    {
        return $this->belongsTo(DayMuscle::class, 'day_muscle_id');
    }
    public function training()
    {
        return $this->belongsTo(Training::class, 'training_id')->select('id', 'name', 'details', 'image');
    }
    public function push()
    {
        return $this->belongsTo(Push::class, 'push_id')->select('id', 'numbers');
    }
}
