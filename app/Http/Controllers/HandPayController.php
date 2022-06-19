<?php

namespace App\Http\Controllers;

use App\Models\HandPay;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\HandPay\Create;
use App\Http\Requests\HandPay\Update;
use App\Repositories\DebtsRepository;
use App\Repositories\HandPayRepository;
use Symfony\Component\HttpFoundation\Response;
use Maatwebsite\Excel\Validators\ValidationException;

class HandPayController extends Controller
{
    private $HandPayRepo;
    private $DebtsRepo;
    public function __construct(HandPayRepository $HandPayRepo, DebtsRepository $DebtsRepo)
    {
        $this->HandPayRepo = $HandPayRepo;
        $this->DebtsRepo = $DebtsRepo;
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $pay = $request->validated();
        DB::beginTransaction();//start transaction
        try {
        $pay['user_id'] = auth()->user()->id;
        $pay['gym_id'] = auth()->user()->gym->uuid;
        $getDebt = $this->DebtsRepo->show($pay['debt_id']);
        $pay['old_price'] = $getDebt->price;
        $pay['current_price'] = $getDebt->price - $pay['price'];
        $this->DebtsRepo->update($pay['debt_id'], ['price' => $pay['current_price']]);
        $response = $this->HandPayRepo->create($pay);
        } catch(\Exception $e)
        {
            DB::rollback();//rollback transaction if exception
            throw $e;
        }

        DB::commit();//commit transaction if no exception
        return response()->json([
            'success' => true,
            'message' => 'hand pay created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HandPay  $debt
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        // $pay = $request->validated();
        // $this->HandPayRepo->update($id, $pay);
        // return response()->json([
        //     'success' => true,
        //     'message' => 'hand pay updated successfully',
        // ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HandPay  $debt
     * @return \Illuminate\Http\Response
     */
    public function destroy(HandPay $pay)
    {
        DB::beginTransaction();//start transaction
        try {
        $getDebt = $this->DebtsRepo->show($pay['debt_id']);
        $lastDebtPrice = $getDebt->price + $pay['price'];
        $this->DebtsRepo->update($pay['debt_id'], ['price' => $lastDebtPrice]);
        $this->HandPayRepo->delete($pay);
        } catch(\Exception $e)
        {
            DB::rollback();//rollback transaction if exception
            throw $e;
        }

        DB::commit();//commit transaction if no exception
        return response()->json([
            'success' => true,
            'message' => 'hand pay deleted successfully',
        ], Response::HTTP_OK);
    }
}
