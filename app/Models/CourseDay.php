<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CourseDay extends Model
{ use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'gym_id', 'course_id', 'day_id', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'gym', 'course', 'day'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [];

    //relationships
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid')->select('uuid', 'name', 'logo');
    }
    public function day()
    {
        return $this->belongsTo(Day::class, 'day_id')->select('id', 'name');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}
