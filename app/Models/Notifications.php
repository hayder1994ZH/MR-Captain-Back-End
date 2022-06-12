<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable = [
       'id', 'title', 'user_id', 'publish_user_id', 'reel_id', 'reference_id', 'reference_type', 'created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'user', 'publish_user', 'reel', 'reel.user', 'reference', 'reference.user'
    ];
    protected $hidden = [
        'is_deleted',
    ];
    protected $casts = [
        'user_id' => 'int',
        'reference_id' => 'int',
        'publish_user_id' => 'int'
    ];

    //Relations
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reel()
    {
        return $this->belongsTo(Reels::class, 'reel_id');
    }
    public function publish_user()
    {
        return $this->belongsTo(User::class, 'publish_user_id');
    }
    public function reference()
    {
        return $this->morphTo();
    }
}
