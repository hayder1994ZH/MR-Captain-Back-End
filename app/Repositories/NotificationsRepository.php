<?php
namespace App\Repositories;

use App\Models\Notifications;
use Spatie\QueryBuilder\QueryBuilder;

class NotificationsRepository extends BaseRepository{
    public function __construct()
    {
        parent::__construct(new Notifications());
    }
    //Base repo to get all items
    public function getList($take = 10, $is_comment = 0, $is_like = 0){
        $result = QueryBuilder::for($this->model)
                                ->allowedIncludes($this->getRelationMethod())
                                ->allowedFilters($this->getProperties())
                                ->allowedSorts($this->getProperties())
                                ->where('publish_user_id', auth()->user()->id);
                                if($is_comment){
                                    $result = $result->where('reference_type', 'App\Models\Comments');
                                }
                                if($is_like){
                                    $result = $result->where('reference_type', 'App\Models\Likes');
                                }
        return $result->paginate($take);
    } 
}
