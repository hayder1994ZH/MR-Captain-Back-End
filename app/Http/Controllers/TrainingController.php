<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Helpers\Utilities;
use Illuminate\Http\Request;
use App\Http\Requests\Training\Create;
use App\Http\Requests\Training\Update;
use App\Http\Requests\Index\Pagination;
use App\Repositories\TrainingRepository;
use Symfony\Component\HttpFoundation\Response;

class TrainingController extends Controller
{
    private $TrainingRepo;
    public function __construct(TrainingRepository $TrainingRepo)
    {
        $this->TrainingRepo = $TrainingRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->TrainingRepo->getList($request->take);
    }

    /**
     * Display a listing of my gym Trainings.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyGymTraininges(Pagination $request)
    {
        $request->validated();
        return $this->TrainingRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $training = $request->validated();
        $training['gym_id'] = auth()->user()->gym->uuid;
        if($request->hasFile('image')){
            $training['image'] = $request->file('image')->store('training-images');
        }
        $response = $this->TrainingRepo->create($training);
        return response()->json([
            'success' => true,
            'message' => 'Training created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Training  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->TrainingRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Training  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $training = $request->validated();
        $this->TrainingRepo->update($id, $training);
        return response()->json([
            'success' => true,
            'message' => 'Training updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Training  $training
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training)
    {
        if(!Utilities::admin() && !Utilities::captain()){
            return response()->json([
                'success' => false,
                'message' => 'permission denied',
            ], Response::HTTP_FORBIDDEN);
        }
        $this->TrainingRepo->delete($training);
        return response()->json([
            'success' => true,
            'message' => 'Training deleted successfully',
        ], Response::HTTP_OK);
    }
}
