<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notifications extends Model
{
    use SoftDeletes;
    protected $fillable = [
       'id', 'title', 'user_id', 'publish_user_id', 'reel_id', 'reference_id', 'reference_type', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $hidden = [
        'deleted_at',
    ];
    protected $relations = [
        'user', 'reference', 'reference.user'
    ];
    protected $casts = [
        'user_id' => 'int',
        'reference_id' => 'int',
    ];

    //Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reference()
    {
        return $this->morphTo();
    }
}
