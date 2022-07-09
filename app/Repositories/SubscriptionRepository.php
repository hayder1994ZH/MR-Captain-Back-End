<?php
namespace App\Repositories;

use Carbon\Carbon;
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
        return Cards::where('gym_id', auth()->user()->gym->uuid)->find($id);
    }
    //Base repo to get card days by id
    public function getLastSubscrip($id){
        return $this->model->where('player_id', $id)->latest()->first();
    }
    //Base repo to get all items getLastSubscripDate
    public function mySubscription($take = 10, $player_id = null){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid);
                                if($player_id){
                                    $result->where('player_id', $player_id);
                                }
        return $result->paginate($take);
    } 
}
