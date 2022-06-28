<?php
namespace App\Repositories;

use App\Models\Versions;

class VersionsRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Versions());
    }

    public  function getVersion($value = '')
    {
        if($value){
            return $this->model->where('version', $value)->first();
        }
    }
}
