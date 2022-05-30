<?php

namespace App\Models;

use DateTimeInterface;
use App\Models\RelationshipsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gym extends Model
{
    use HasFactory, RelationshipsTrait, SoftDeletes;
    protected $fillable = [
        'id', 'name', 'phone', 'logo', 'gender', 'country', 'city', 'is_ads', 'is_active', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'users',
    ];

    protected $hidden = [
        'logo'
    ];

    protected $appends = [
        'logo_url' 
    ];
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('public') . $this->logo : null;
    }

    protected $casts = [
        'is_ads' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    //Relations
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
