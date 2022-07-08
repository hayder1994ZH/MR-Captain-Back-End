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
        return Cards::findOrFail($id)->days;
    }

    //Base repo to get card days by id
    public function getLastSubscrip($id){
        return $this->model->where('player_id', $id)->latest()->first();
    }
    //Base repo to get all items getLastSubscripDate
    public function mySubscription($take = 10, $current_day = null, $player_not_expaired = null, $player_expaired = null){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid);
                                if($current_day){
                                    $result->whereDate('start_date', Carbon::today());
                                }
                                if($player_not_expaired){
                                    $result->whereDate('expair_date', '>', Carbon::today());
                                }
                                if($player_expaired){
                                    $result->whereDate('expair_date', '<', Carbon::today());
                                }
        return $result->paginate($take);
    } 
    
}
