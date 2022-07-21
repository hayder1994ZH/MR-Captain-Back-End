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
                                ->where('rule_id', 5);
                                if(auth()->user()->gym->uuid){
                                    $result->where('gym_id', auth()->user()->gym->uuid);
                                }
                                if($current_day){
                                    $result->whereHas('todaySubscription');
                                }
                                if($player_not_expaired){
                                    $result->whereHas('notExpireSubscription');
                                }
                                if($player_expaired){
                                    $result->doesntHave('expireSubscription');
                                }
                                if($player_has_debt){
                                    $result->whereHas('debts');
                                }
        return $result->paginate($take);
    } 

    public function checkIfPlayerInMyGym($player_id){
        return $this->model->where('gym_id', auth()->user()->gym->uuid)
                            ->where('id', $player_id)
                            ->first();
    }

    public function LogoutFromGym($player_id){
        $player =  $this->model->where('gym_id', auth()->user()->gym->uuid)
                            ->where('id', $player_id)
                            ->first();
        $player->update([
            'gym_id' => null
        ]);
    }
}
