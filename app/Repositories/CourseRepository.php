<?php
namespace App\Repositories;

use App\Models\Cards;
use App\Models\Course;
use Spatie\QueryBuilder\QueryBuilder;

class CourseRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Course());
    }
    //Base repo to get all items
    public function myCourse($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('player_id', auth()->user()->id);
        return $result->paginate($take);
    } 
    
}
