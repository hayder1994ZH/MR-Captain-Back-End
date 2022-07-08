<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\User;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new User());
    }
    public function checkUserExists($userId)
    {
        return $this->model->where('id', $userId)->first();
    }
    
    //Base repo to get all items for my gym 
    public function getListMyGymAdminsAndCaptains($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid)
                                ->where(function($query){
                                    $query->where('rule_id', 3)
                                            ->orWhere('rule_id', 2);
                                });
        return $result->paginate($take);
    } 
}
