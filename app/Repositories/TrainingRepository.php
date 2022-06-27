<?php
namespace App\Repositories;

use App\Models\Training;

class TrainingRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Training());
    }
}
