<?php
namespace App\Repositories;

use App\Models\Debts;
use Spatie\QueryBuilder\QueryBuilder;

class DebtsRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Debts());
    }
    //Base repo to get all items
    public function getListDebts($take = 10, $player_id){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties());
                                if($player_id){
                                    $result->where('player_id', $player_id);
                                }
        return $result->paginate($take);
    } 

    //Base repo to get all items for my gym
    public function getListMyGymPlayer($take = 10, $player_has_debts = null){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid);
                                if($player_has_debts){
                                    $result->where('price', '>', 0);
                                }
        return $result->paginate($take);
    } 
}
