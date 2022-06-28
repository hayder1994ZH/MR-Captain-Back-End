<?php

namespace App\Models;

use DateTimeInterface;
use App\Helpers\Utilities;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gym extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'uuid', 'logo', 'long', 'lat', 'city_id', 'is_ads', 'is_active', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $hidden = [
        'deleted_at', 
    ];
    protected $relations = [];
    protected $appends = [
        'logo_url'
    ];
    public function getLogoUrlAttribute()
    {
        return $this->logo ? request()->get('host') . Utilities::$imageBucket . $this->logo : null;
    }
    protected $casts = [
        'is_ads' => 'boolean',
        'is_active' => 'boolean',
        'city_id' => 'integer',
    ];
}
