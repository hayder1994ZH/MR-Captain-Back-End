<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use App\Http\Requests\Purchase\Create;
use App\Http\Requests\Purchase\Update;
use App\Http\Requests\Index\Pagination;
use App\Repositories\PurchaseRepository;
use App\Http\Requests\Purchase\DateValidate;
use Symfony\Component\HttpFoundation\Response;

class PurchaseController extends Controller
{
    private $PurchaseRepo;
    public function __construct(PurchaseRepository $PurchaseRepo)
    {
        $this->PurchaseRepo = $PurchaseRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->PurchaseRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyPurchase(Pagination $request)
    {
        $request->validated();
        return $this->PurchaseRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $purchase = $request->validated();
        $purchase['user_id'] = auth()->user()->id;
        $purchase['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->PurchaseRepo->create($purchase);
        return response()->json([
            'success' => true,
            'message' => 'purchase created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $Purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->PurchaseRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $Purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $purchase = $request->validated();
        $this->PurchaseRepo->update($id, $purchase);
        return response()->json([
            'success' => true,
            'message' => 'purchase updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $Purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $this->PurchaseRepo->delete($purchase);
        return response()->json([
            'success' => true,
            'message' => 'purche$purchase deleted successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyPurchaseTotalPrice(DateValidate $request)
    {
        $request->validated();
        $fromDate = $request->fromDate;
        $toDate = $request->toDate;
        return $this->PurchaseRepo->myPurchaseSumPriceBetweenTowDate($fromDate, $toDate);
    }
}
