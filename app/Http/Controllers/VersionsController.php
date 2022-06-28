<?php

namespace App\Http\Controllers;

use App\Models\Versions;
use Illuminate\Http\Request;
use App\Http\Requests\Versions\Create;
use App\Http\Requests\Versions\Update;
use App\Http\Requests\Index\Pagination;
use App\Repositories\VersionsRepository;
use Symfony\Component\HttpFoundation\Response;

class VersionsController extends Controller
{
    private $VersionsRepo;
    public function __construct(VersionsRepository $VersionsRepo)
    {
        $this->VersionsRepo = $VersionsRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->VersionsRepo->getList($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $version = $request->validated();
        $response = $this->VersionsRepo->create($version);
        return response()->json([
            'success' => true,
            'message' => 'Version created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Versions  $Versions
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->VersionsRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Versions  $Versions
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $version = $request->validated();
        $this->VersionsRepo->update($id, $version);
        return response()->json([
            'success' => true,
            'message' => 'Version updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Versions  $Versions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Versions $version)
    {
        $this->VersionsRepo->delete($version);
        return response()->json([
            'success' => true,
            'message' => 'Version deleted successfully',
        ], 
        Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Versions  $Versions
     * @return \Illuminate\Http\Response
     */
    public function getPublicVersion($version)
    {
        return $this->VersionsRepo->getVersion($version);
    }
}
