<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Versions extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'id', 
       'version' ,
       'android_url' ,
       'android_public',
       'android_active',
       'android_cache',
       'ios_url' ,
       'ios_public',
       'ios_active',
       'ios_cache',
       'created_at', 
       'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $hidden = [
        'deleted_at',
    ];
    protected $relations = [];
    protected $casts = [
        'version' => 'string',
        'android_url' => 'string',
        'android_public' => 'boolean',
        'android_active' => 'boolean',
        'android_cache' => 'boolean',
        'ios_url' => 'string',
        'ios_public' => 'boolean',
        'ios_active' => 'boolean',
        'ios_cache' => 'boolean',
    ];
}
