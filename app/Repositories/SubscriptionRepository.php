<?php
namespace App\Repositories;

use App\Models\Cards;
use App\Models\Subscription;
use Spatie\QueryBuilder\QueryBuilder;

class SubscriptionRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Subscription());
    }
    //Base repo to get card days by id
    public function getCard($id){
        return Cards::findOrFail($id)->days;
    }
    //Base repo to get all items
    public function mySubscription($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid);
                                // ->where('player_id', auth()->user()->id);
        return $result->paginate($take);
    } 
    
}
