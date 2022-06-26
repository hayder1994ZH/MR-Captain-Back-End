<?php
namespace App\Repositories;

use App\Models\Muscle;

class MuscleRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Muscle());
    }
}
