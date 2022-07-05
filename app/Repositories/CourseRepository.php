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
    //Base repo to get full Course
    public function fullCourse($id){
        $course = $this->model->where('id', $id)
                            ->with('days', 'days.muscles', 'days.muscles', 'days.muscles.trainings')
                            ->get();
        return $this->mapping($course);
    }

    public function mapping($course){
        return $course->map(function($item){
           $data['title'] =  $item->title;
           $data['details'] =  $item->details;
           $data['weight'] =  $item->weight;
           $data['price'] =  $item->price;
           $data['captain_id'] =  $item->captain_id;
           $data['player_id'] =  $item->player_id;
           $data['created_at'] =  $item->created_at;
           $data['updated_at'] =  $item->updated_at;
           $data['captain'] =  $item->captain;
           $data['gym'] =  $item->gym;
           $data['player'] =  $item->player;
           $data['days'] =  
           $item->days->map(function($days){
                $day['id'] =  $days->day->id;
                $day['name'] =  $days->day->name;
                $day['muscles'] =  $days->muscles
                ->map(function($muscles){
                    $muscle['id'] =  $muscles->muscle->id;
                    $muscle['name'] =  $muscles->muscle->name;
                    $muscle['trainings'] =  $muscles->trainings;
                    return $muscle;
               });
                return $day;
           });
            return $data;
        });
        
    }
    
    
}
