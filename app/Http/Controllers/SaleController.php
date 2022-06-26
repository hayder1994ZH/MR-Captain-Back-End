<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Requests\Sale\Create;
use App\Http\Requests\Sale\Update;
use App\Repositories\SaleRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    private $SaleRepo;
    public function __construct(SaleRepository $SaleRepo)
    {
        $this->SaleRepo = $SaleRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->SaleRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMySales(Pagination $request)
    {
        $request->validated();
        return $this->SaleRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $sale = $request->validated();
        $sale['user_id'] = auth()->user()->id;
        $sale['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->SaleRepo->create($sale);
        return response()->json([
            'success' => true,
            'message' => 'Sale created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $Sale
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->SaleRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $Sale
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $sale = $request->validated();
        $this->SaleRepo->update($id, $sale);
        return response()->json([
            'success' => true,
            'message' => 'Sale updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $Sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        $this->SaleRepo->delete($sale);
        return response()->json([
            'success' => true,
            'message' => 'Sale deleted successfully',
        ], Response::HTTP_OK);
    }
}
