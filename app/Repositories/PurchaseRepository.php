<?php
namespace App\Repositories;

use App\Models\Sale;
use App\Models\Debts;
use App\Models\Purchase;
use Spatie\QueryBuilder\QueryBuilder;

class PurchaseRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Purchase());
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
        $debts = QueryBuilder::for(Debts::class)
                                ->where('gym_id', auth()->user()->gym->uuid)
                                ->whereBetween('created_at', [$fromDate, $toDate])
                                ->sum('price');
        return [
            'purchase' => $purchase,
            'sales' => $sales,
            'debts' => $debts,
            'profits' => $profits
        ];
    }
}
