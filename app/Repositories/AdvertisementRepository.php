<?php
namespace App\Repositories;

use App\Models\Advertisement;
use Spatie\QueryBuilder\QueryBuilder;

class AdvertisementRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Advertisement());
    }

    //Base repo to get all items
    public function myAdvertisement($take = 10){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('is_active', 1)
                                ->where(function($query){
                                    $query->where('city_id', auth()->user()->city_id)
                                          ->orWhere('country_id', auth()->user()->city->country_id);
                                });
        return $result->paginate($take);
    } 
    
    //Base repo to get all items
    public function getListAds($take = 10, $city_id = null, $country_id = null){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties());
                                if($city_id){
                                    $result->where('city_id', $city_id);
                                }
                                if($country_id){
                                    $result->where('country_id', $country_id);
                                }

        return $result->paginate($take);
    } 
}
