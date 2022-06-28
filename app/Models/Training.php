<?php

namespace App\Models;

use DateTimeInterface;
use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'details', 'image', 'gym_id', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'gym'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [];
    protected $appends = [
       'image_url',
    ];
    public function getImageUrlAttribute()
    {
        return $this->image ? request()->get('host') . Utilities::$imageBucket . $this->image : null;
    }
    
    //relationships
    public function gym()
    {
        return $this->belongsTo(Gym::class, 'gym_id', 'uuid')->select('uuid', 'name', 'logo');
    }
}
