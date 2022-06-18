<?php
namespace App\Repositories;

use App\Models\Music;

class MusicRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Music());
    }
}
