<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\Country\Create;
use App\Http\Requests\Country\Update;
use App\Http\Requests\Index\Pagination;
use App\Repositories\CountryRepository;
use Symfony\Component\HttpFoundation\Response;

class CountryController extends Controller
{
    private $CountryRepo;
    public function __construct(CountryRepository $CountryRepo)
    {
        $this->CountryRepo = $CountryRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->CountryRepo->getList($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $country = $request->validated();
        $response = $this->CountryRepo->create($country);
        return response()->json([
            'success' => true,
            'message' => 'country created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->CountryRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $country = $request->validated();
        $this->CountryRepo->update($id, $country);
        return response()->json([
            'success' => true,
            'message' => 'country updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $Country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $this->CountryRepo->delete($country);
        return response()->json([
            'success' => true,
            'message' => 'country deleted successfully',
        ], Response::HTTP_OK);
    }
}
