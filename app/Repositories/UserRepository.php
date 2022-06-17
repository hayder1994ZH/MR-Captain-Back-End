<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new User());
    }
    public function checkUserExists($userId)
    {
        return $this->model->where('id', $userId)->first();
    }
}
