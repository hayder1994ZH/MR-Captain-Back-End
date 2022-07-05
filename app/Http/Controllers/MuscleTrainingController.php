<?php

namespace App\Http\Controllers;

use App\Helpers\Utilities;
use Illuminate\Http\Request;
use App\Models\MuscleTraining;
use App\Http\Requests\Index\Pagination;
use App\Http\Requests\MuscleTraining\Create;
use App\Http\Requests\MuscleTraining\Update;
use App\Repositories\MuscleTrainingRepository;
use Symfony\Component\HttpFoundation\Response;

class MuscleTrainingController extends Controller
{
    private $MuscleTrainingRepo;
    public function __construct(MuscleTrainingRepository $MuscleTrainingRepo)
    {
        $this->MuscleTrainingRepo = $MuscleTrainingRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->MuscleTrainingRepo->getList($request->take);
    }

    /**
     * Display a listing of my gym MuscleTrainings.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymMuscleTrainings(Pagination $request)
    {
        $request->validated();
        return $this->MuscleTrainingRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $MuscleTraining = $request->validated();
        $MuscleTraining['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->MuscleTrainingRepo->create($MuscleTraining);
        return response()->json([
            'success' => true,
            'message' => 'Muscle and training created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MuscleTraining  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->MuscleTrainingRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MuscleTraining  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $MuscleTraining = $request->validated();
        $this->MuscleTrainingRepo->update($id, $MuscleTraining);
        return response()->json([
            'success' => true,
            'message' => 'Muscle and training updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MuscleTraining  $MuscleTraining
     * @return \Illuminate\Http\Response
     */
    public function destroy(MuscleTraining $trainings)
    {
        if(!Utilities::admin() && !Utilities::captain()){
            return response()->json([
                'success' => false,
                'message' => 'permission denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $this->MuscleTrainingRepo->delete($trainings);
        return response()->json([
            'success' => true,
            'message' => 'Muscle and training deleted successfully',
        ], Response::HTTP_OK);
    }
}
