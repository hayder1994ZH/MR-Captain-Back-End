<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeightHistory;
use App\Http\Requests\Index\Pagination;
use App\Http\Requests\WeightHistory\Create;
use App\Http\Requests\WeightHistory\Update;
use App\Repositories\WeightHistoryRepository;
use Symfony\Component\HttpFoundation\Response;

class WeightHistoryController extends Controller
{
    private $WeightHistoryRepo;
    public function __construct(WeightHistoryRepository $WeightHistoryRepo)
    {
        $this->WeightHistoryRepo = $WeightHistoryRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->WeightHistoryRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyWeightHistories(Pagination $request)
    {
        $request->validated();
        return $this->WeightHistoryRepo->myWeightHistory($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $weight = $request->validated();
        $response = $this->WeightHistoryRepo->create($weight);
        return response()->json([
            'success' => true,
            'message' => 'weight created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeightHistory  $WeightHistory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->WeightHistoryRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeightHistory  $WeightHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $weight = $request->validated();
        $this->WeightHistoryRepo->update($id, $weight);
        return response()->json([
            'success' => true,
            'message' => 'weight updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeightHistory  $WeightHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(WeightHistory $history)
    {
        $this->WeightHistoryRepo->delete($history);
        return response()->json([
            'success' => true,
            'message' => 'weight deleted successfully',
        ], Response::HTTP_OK);
    }
}
