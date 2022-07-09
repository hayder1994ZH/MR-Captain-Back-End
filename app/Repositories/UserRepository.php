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
    public function getListMyGymPlayers($take = 10, $current_day = null, $player_not_expaired = null, $player_expaired = null, $player_has_debt = null){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid)
                                ->where('rule_id', 5);
                                if($current_day){
                                    $result->whereHas('subscriptions', function($query){
                                        $query->whereDate('start_date', Carbon::today());
                                    });
                                }
                                if($player_not_expaired){
                                    $result->whereHas('subscriptions', function($query){
                                        $query->whereDate('expair_date', '<=', Carbon::today());
                                    });
                                }
                                if($player_expaired){
                                    $result->whereHas('subscriptions', function($query){
                                        $query->whereDate('expair_date', '=<', Carbon::today());
                                    });
                                }
                                if($player_has_debt){
                                    $result->whereHas('debts');
                                }
        return $result->paginate($take);
    } 
}
