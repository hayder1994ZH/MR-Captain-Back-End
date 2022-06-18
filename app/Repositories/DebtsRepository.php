<?php
namespace App\Repositories;

use App\Models\Debts;
use Spatie\QueryBuilder\QueryBuilder;

class DebtsRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Debts());
    }
}
