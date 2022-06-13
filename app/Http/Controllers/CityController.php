<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Http\Requests\City\Create;
use App\Http\Requests\City\Update;
use App\Repositories\CityRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    private $CityRepo;
    public function __construct(CityRepository $CityRepo)
    {
        $this->CityRepo = $CityRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->CityRepo->getList($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $city = $request->validated();
        $response = $this->CityRepo->create($city);
        return response()->json([
            'success' => true,
            'message' => 'city created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $City
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->CityRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $City
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $city = $request->validated();
        $this->CityRepo->update($id, $city);
        return response()->json([
            'success' => true,
            'message' => 'city updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $City
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $this->CityRepo->delete($city);
        return response()->json([
            'success' => true,
            'message' => 'city deleted successfully',
        ], Response::HTTP_OK);
    }
}
