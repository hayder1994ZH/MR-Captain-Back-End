<?php
namespace App\Repositories;

use App\Models\WeightHistory;
use Spatie\QueryBuilder\QueryBuilder;

class WeightHistoryRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new WeightHistory());
    }
    //get all my weight history
    public function myWeightHistory($take, $player_id)
    {
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties());
                                if($player_id){
                                    $result->where('user_id', $player_id);
                                }else{
                                    $result->where('user_id', auth()->user()->id);
                                }
        return $result->paginate($take);
    }
}
