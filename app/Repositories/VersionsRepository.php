<?php
namespace App\Repositories;

use App\Models\Versions;

class VersionsRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Versions());
    }
}
