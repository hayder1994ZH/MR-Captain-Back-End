<?php

namespace App\Http\Controllers;

use App\Models\CardsGym;
use App\Http\Requests\CardsGym\Update;
use App\Http\Requests\Index\Pagination;
use App\Repositories\CardsGymRepository;
use App\Http\Requests\CardsGym\Create;
use Symfony\Component\HttpFoundation\Response;

class CardsGymController extends Controller
{
    private $CardsGymRepo;
    public function __construct(CardsGymRepository $CardsGymRepo)
    {
        $this->CardsGymRepo = $CardsGymRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->CardsGymRepo->getList($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $card = $request->validated();
        $card['user_id'] = auth()->user()->id;
        $response = $this->CardsGymRepo->create($card);
        return response()->json([
            'success' => true,
            'message' => 'card created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CardsGym  $CardsGym
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->CardsGymRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CardsGym  $CardsGym
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $card = $request->validated();
        $this->CardsGymRepo->update($id, $card);
        return response()->json([
            'success' => true,
            'message' => 'card updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CardsGym  $CardsGym
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardsGym $card)
    {
        $this->CardsGymRepo->delete($card);
        return response()->json([
            'success' => true,
            'message' => 'card deleted successfully',
        ], Response::HTTP_OK);
    }
}
