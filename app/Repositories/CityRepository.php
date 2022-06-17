<?php
namespace App\Repositories;

use App\Models\City;

class CityRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new City());
    }
}
