<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifications;
use App\Http\Requests\Index\Pagination;
use App\Repositories\NotificationsRepository;

class NotificationsController extends Controller
{
    private $NotificationsRepo;
    public function __construct(NotificationsRepository $NotificationsRepo)
    {
        $this->NotificationsRepo = $NotificationsRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        $is_comment = $request->is_comment;
        $is_like = $request->is_like;
        $take = $request->take;
        return $this->NotificationsRepo->getList($take, $is_comment, $is_like);
    }
}
