<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\Gym\Create;
use App\Http\Requests\Gym\Update;
use App\Repositories\GymRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class GymController extends Controller
{
    private $GymRepo;
    public function __construct(GymRepository $GymRepo)
    {
        $this->GymRepo = $GymRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->GymRepo->getList($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $gym = $request->validated();
        if($request->hasFile('logo')){
            $gym['logo'] = $request->file('logo')->store('gym-logo');
        }
        $gym['uuid'] =  Str::uuid();
        $response = $this->GymRepo->create($gym);
        return response()->json([
            'success' => true,
            'message' => 'Gym created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gym  $Gym
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->GymRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gym  $Gym
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $gym = $request->validated();
        if($request->hasFile('logo')){
            $gym['logo'] = $request->file('logo')->store('gym-logo');
        }
        $this->GymRepo->update($id, $gym);
        return response()->json([
            'success' => true,
            'message' => 'Gym updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gym  $Gym
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gym $gym)
    {
        $this->GymRepo->delete($gym);
        return response()->json([
            'success' => true,
            'message' => 'Gym deleted successfully',
        ], Response::HTTP_OK);
    }
}
