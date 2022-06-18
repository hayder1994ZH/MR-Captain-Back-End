<?php
namespace App\Repositories;

use App\Models\Sale;
use Spatie\QueryBuilder\QueryBuilder;

class SaleRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Sale());
    }
    //Base repo to get all my sales
    public function mySales($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid);
        return $result->paginate($take);
    } 
}
