<?php
namespace App\Repositories;

use Carbon\Carbon;
use App\Models\CardsGym;
use App\Models\SubscriptionsGym;
use Spatie\QueryBuilder\QueryBuilder;

class SubscriptionsGymRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new SubscriptionsGym());
    }
    //Base repo to get card days by id
    public function getCard($id){
        return CardsGym::findOrFail($id)->days;
    }

    //Base repo to get card days by id
    public function getLastSubscrip($uuid){
        return $this->model->where('gym_id', $uuid)->latest()->first();
    }
    //Base repo to get all items getLastSubscripDate
    public function mySubscription($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid);
        return $result->paginate($take);
    } 
}