<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Rules extends Model
{
    protected $fillable = [
        'id', 'name', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'users',
    ];
    protected $hidden = [
        'is_deleted',
    ];
    //Relations
    public function users()
    {
        return $this->hasMany(User::class, 'rule_id');
    }

}
