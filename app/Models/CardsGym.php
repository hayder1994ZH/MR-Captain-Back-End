<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardsGym extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'price', 'days', 'user_id','created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'user',
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'user_id' => 'integer',
    ];

    //relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
