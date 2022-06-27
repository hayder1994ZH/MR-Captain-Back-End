<?php

namespace App\Http\Controllers;

use App\Models\Muscle;
use App\Helpers\Utilities;
use Illuminate\Http\Request;
use App\Http\Requests\Muscle\Create;
use App\Http\Requests\Muscle\Update;
use App\Repositories\MuscleRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class MuscleController extends Controller
{
    private $MuscleRepo;
    public function __construct(MuscleRepository $MuscleRepo)
    {
        $this->MuscleRepo = $MuscleRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->MuscleRepo->getList($request->take);
    }

    /**
     * Display a listing of my gym Muscles.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymMuscles(Pagination $request)
    {
        $request->validated();
        return $this->MuscleRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $Muscle = $request->validated();
        $Muscle['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->MuscleRepo->create($Muscle);
        return response()->json([
            'success' => true,
            'message' => 'Muscle created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Muscle  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->MuscleRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Muscle  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $muscle = $request->validated();
        $this->MuscleRepo->update($id, $muscle);
        return response()->json([
            'success' => true,
            'message' => 'Muscle updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Muscle  $muscle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Muscle $muscle)
    {
        if(!Utilities::admin() && !Utilities::captain()){
            return response()->json([
                'success' => false,
                'message' => 'permission denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $this->MuscleRepo->delete($muscle);
        return response()->json([
            'success' => true,
            'message' => 'Muscle deleted successfully',
        ], Response::HTTP_OK);
    }
}
