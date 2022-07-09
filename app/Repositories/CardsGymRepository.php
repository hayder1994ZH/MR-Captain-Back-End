<?php
namespace App\Repositories;

use App\Models\CardsGym;
class CardsGymRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new CardsGym());
    }
}