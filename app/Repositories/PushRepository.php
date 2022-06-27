<?php
namespace App\Repositories;

use App\Models\Push;

class PushRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Push());
    }
}
