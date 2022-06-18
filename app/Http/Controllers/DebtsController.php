<?php

namespace App\Http\Controllers;

use App\Models\Debts;
use Illuminate\Http\Request;
use App\Http\Requests\Debts\Create;
use App\Http\Requests\Debts\Update;
use App\Repositories\DebtsRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class DebtsController extends Controller
{
    private $DebtsRepo;
    public function __construct(DebtsRepository $DebtsRepo)
    {
        $this->DebtsRepo = $DebtsRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->DebtsRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyDebts(Pagination $request)
    {
        $request->validated();
        return $this->DebtsRepo->getListMyGym($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $debt = $request->validated();
        $debt['user_id'] = auth()->user()->id;
        $debt['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->DebtsRepo->create($debt);
        return response()->json([
            'success' => true,
            'message' => 'Debt created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Debts  $debt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->DebtsRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Debts  $debt
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $debt = $request->validated();
        $this->DebtsRepo->update($id, $debt);
        return response()->json([
            'success' => true,
            'message' => 'Debt updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Debts  $debt
     * @return \Illuminate\Http\Response
     */
    public function destroy(Debts $debt)
    {
        $this->DebtsRepo->delete($debt);
        return response()->json([
            'success' => true,
            'message' => 'debt deleted successfully',
        ], Response::HTTP_OK);
    }
}
