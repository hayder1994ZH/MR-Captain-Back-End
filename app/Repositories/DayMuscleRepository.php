<?php
namespace App\Repositories;

use App\Models\DayMuscle;

class DayMuscleRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new DayMuscle());
    }
}
