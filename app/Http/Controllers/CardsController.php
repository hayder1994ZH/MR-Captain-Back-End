<?php

namespace App\Http\Controllers;

use App\Models\Cards;
use Illuminate\Http\Request;
use App\Http\Requests\Cards\Create;
use App\Http\Requests\Cards\Update;
use App\Repositories\CardsRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class CardsController extends Controller
{
    private $CardsRepo;
    public function __construct(CardsRepository $CardsRepo)
    {
        $this->CardsRepo = $CardsRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->CardsRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyCards(Pagination $request)
    {
        $request->validated();
        return $this->CardsRepo->myCards($request->take);
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
        $card['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->CardsRepo->create($card);
        return response()->json([
            'success' => true,
            'message' => 'card created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cards  $Cards
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->CardsRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cards  $Cards
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $card = $request->validated();
        $this->CardsRepo->update($id, $card);
        return response()->json([
            'success' => true,
            'message' => 'card updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cards  $Cards
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cards $card)
    {
        $this->CardsRepo->delete($card);
        return response()->json([
            'success' => true,
            'message' => 'card deleted successfully',
        ], Response::HTTP_OK);
    }
}
