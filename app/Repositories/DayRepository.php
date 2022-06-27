<?php
namespace App\Repositories;

use App\Models\Day;

class DayRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Day());
    }
}
