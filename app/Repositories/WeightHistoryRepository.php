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
    public function myWeightHistory($take)
    {
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('user_id', auth()->user()->id);
        return $result->paginate($take);
    }
}
