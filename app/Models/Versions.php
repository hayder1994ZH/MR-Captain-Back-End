<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Versions extends Model
{
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
        'is_deleted',
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
