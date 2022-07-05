<?php
namespace App\Repositories;

use App\Models\MuscleTraining;

class MuscleTrainingRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new MuscleTraining());
    }
}