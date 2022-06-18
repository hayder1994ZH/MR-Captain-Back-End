<?php
namespace App\Repositories;

use App\Models\Sale;
use App\Models\Purchase;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Purchase());
    }
    //Base repo to get all items
    public function myPurchase($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('gym_id', auth()->user()->gym->uuid);
        return $result->paginate($take);
    } 

    public function myPurchaseSumPriceBetweenTowDate($fromDate, $toDate){
        $purchase = QueryBuilder::for($this->model)
                                ->where('gym_id', auth()->user()->gym->uuid)
                                ->whereBetween('created_at', [$fromDate, $toDate])
                                ->sum('price');
        $sales = QueryBuilder::for(Sale::class)
                                ->where('gym_id', auth()->user()->gym->uuid)
                                ->whereBetween('created_at', [$fromDate, $toDate])
                                ->sum('price');
        $profits = $purchase - $sales;
        return [
            'purchase' => $purchase,
            'sales' => $sales,
            'profits' => $profits
        ];
    }
}
