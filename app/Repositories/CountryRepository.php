<?php
namespace App\Repositories;

use App\Models\Country;

class CountryRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Country());
    }
}
