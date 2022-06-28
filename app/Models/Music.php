<?php

namespace App\Models;

use DateTimeInterface;
use App\Helpers\Utilities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Music extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'name', 'image', 'music', 'url','created_at', 'updated_at'
    ];
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d h:i:s');
    }
    protected $relations = [];
    protected $hidden = [
        'deleted_at', 'music', 'url', 'image'
    ];
    protected $casts = [];
    protected $appends = [
        'music_url', 'image_url'
    ];
    public function getMusicUrlAttribute(){
       if($this->music){
           return request()->get('host') . Utilities::$imageBucket . $this->music;
       }
       return $this->url;
    }
    public function getImageUrlAttribute(){
        return $this->image ? request()->get('host') . Utilities::$imageBucket . $this->image : null;
    }
}
