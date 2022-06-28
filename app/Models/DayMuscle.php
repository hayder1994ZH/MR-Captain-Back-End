<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayMuscle extends Model
{ 
    use SoftDeletes;
    protected $fillable = [
        'id', 'course_day_id', 'muscle_id', 'gym_id', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'gym', 'day', 'muscle'
    ];
    protected $hidden = [
        'deleted_at', 'gym_id','muscle_id', 'course_day_id', 'created_at', 'updated_at'
    ];
    protected $casts = [];

    //relationships
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid')->select('uuid', 'name', 'logo');
    }
    public function day()
    {
        return $this->belongsTo(CourseDay::class, 'course_day_id');
    }
    public function muscle()
    {
        return $this->belongsTo(Muscle::class, 'muscle_id');
    }
}
