<?php
namespace App\Repositories;

use App\Models\CourseDay;

class CourseDayRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new CourseDay());
    }
}
