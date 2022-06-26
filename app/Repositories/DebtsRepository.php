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
}
