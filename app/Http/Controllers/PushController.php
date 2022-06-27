<?php

namespace App\Http\Controllers;

use App\Models\Push;
use App\Helpers\Utilities;
use App\Http\Requests\Push\Create;
use App\Http\Requests\Push\Update;
use App\Repositories\PushRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class PushController extends Controller
{
    private $PushRepo;
    public function __construct(PushRepository $PushRepo)
    {
        $this->PushRepo = $PushRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->PushRepo->getList($request->take);
    }

    /**
     * Display a listing of my gym Pushs.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymPushes(Pagination $request)
    {
        $request->validated();
        return $this->PushRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $push = $request->validated();
        $push['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->PushRepo->create($push);
        return response()->json([
            'success' => true,
            'message' => 'Push created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Push  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->PushRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Push  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $push = $request->validated();
        $this->PushRepo->update($id, $push);
        return response()->json([
            'success' => true,
            'message' => 'Push updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Push  $Push
     * @return \Illuminate\Http\Response
     */
    public function destroy(Push $push)
    {
        if(!Utilities::admin() && !Utilities::captain()){
            return response()->json([
                'success' => false,
                'message' => 'permission denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $this->PushRepo->delete($push);
        return response()->json([
            'success' => true,
            'message' => 'Push deleted successfully',
        ], Response::HTTP_OK);
    }
}
