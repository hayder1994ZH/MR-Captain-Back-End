<?php
namespace App\Repositories;

use App\Models\Gym;

class GymRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Gym());
    }
}
