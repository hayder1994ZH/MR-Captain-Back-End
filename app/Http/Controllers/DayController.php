<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Helpers\Utilities;
use Illuminate\Http\Request;
use App\Http\Requests\Day\Create;
use App\Http\Requests\Day\Update;
use App\Repositories\DayRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class DayController extends Controller
{
    private $DayRepo;
    public function __construct(DayRepository $DayRepo)
    {
        $this->DayRepo = $DayRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->DayRepo->getList($request->take);
    }

    /**
     * Display a listing of my gym Days.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymDays(Pagination $request)
    {
        $request->validated();
        return $this->DayRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $day = $request->validated();
        $day['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->DayRepo->create($day);
        return response()->json([
            'success' => true,
            'message' => 'Day created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Day  $debt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->DayRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Day  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $day = $request->validated();
        $this->DayRepo->update($id, $day);
        return response()->json([
            'success' => true,
            'message' => 'Day updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Day  $day
     * @return \Illuminate\Http\Response
     */
    public function destroy(Day $day)
    {
        if(!Utilities::admin() && !Utilities::captain()){
            return response()->json([
                'success' => false,
                'message' => 'permission denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $this->DayRepo->delete($day);
        return response()->json([
            'success' => true,
            'message' => 'Day deleted successfully',
        ], Response::HTTP_OK);
    }
}
