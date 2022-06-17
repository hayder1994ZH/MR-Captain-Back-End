<?php
namespace App\Repositories;

use App\Models\Cards;
use Spatie\QueryBuilder\QueryBuilder;

class CardsRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Cards());
    }
    //get all my cards
    public function myCards($take)
    {
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid)
                                ->where('user_id', auth()->user()->id);
        return $result->paginate($take);
    }
}
