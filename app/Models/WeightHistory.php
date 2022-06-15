<?php

namespace App\Models;

use DateTimeInterface;
use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeightHistory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'weight', 'date', 'user_id', 'created_at', 'update_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [
        'user'
    ];
    protected $hidden = [
        'deleted_at',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'date' => 'datetime',
    ];

    //relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
