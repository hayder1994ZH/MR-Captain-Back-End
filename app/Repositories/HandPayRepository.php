<?php
namespace App\Repositories;

use App\Models\HandPay;

class HandPayRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new HandPay());
    }
}
