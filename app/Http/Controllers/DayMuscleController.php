<?php

namespace App\Http\Controllers;

use App\Models\DayMuscle;
use App\Helpers\Utilities;
use Illuminate\Http\Request;
use App\Http\Requests\DayMuscle\Create;
use App\Http\Requests\DayMuscle\Update;
use App\Http\Requests\Index\Pagination;
use App\Repositories\DayMuscleRepository;
use Symfony\Component\HttpFoundation\Response;

class DayMuscleController extends Controller
{
    private $DayMuscleRepo;
    public function __construct(DayMuscleRepository $DayMuscleRepo)
    {
        $this->DayMuscleRepo = $DayMuscleRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->DayMuscleRepo->getList($request->take);
    }

    /**
     * Display a listing of my gym DayMuscles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymDayMuscles(Pagination $request)
    {
        $request->validated();
        return $this->DayMuscleRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $DayMuscle = $request->validated();
        $DayMuscle['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->DayMuscleRepo->create($DayMuscle);
        return response()->json([
            'success' => true,
            'message' => 'Day and muscle created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DayMuscle  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->DayMuscleRepo->show($id)->trainings;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DayMuscle  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $DayMuscle = $request->validated();
        $this->DayMuscleRepo->update($id, $DayMuscle);
        return response()->json([
            'success' => true,
            'message' => 'Day and muscle updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DayMuscle  $muscles
     * @return \Illuminate\Http\Response
     */
    public function destroy(DayMuscle $muscles)
    {
        if(!Utilities::admin() && !Utilities::captain()){
            return response()->json([
                'success' => false,
                'message' => 'permission denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $this->DayMuscleRepo->delete($muscles);
        return response()->json([
            'success' => true,
            'message' => 'Day and muscle deleted successfully',
        ], Response::HTTP_OK);
    }
}
