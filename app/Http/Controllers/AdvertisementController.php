<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Http\Requests\Advertisement\Create;
use App\Http\Requests\Advertisement\Update;
use App\Repositories\AdvertisementRepository;
use App\Http\Requests\Index\Pagination;
use Symfony\Component\HttpFoundation\Response;

class AdvertisementController extends Controller
{
    private $AdvertisementRepo;
    public function __construct(AdvertisementRepository $AdvertisementRepo)
    {
        $this->AdvertisementRepo = $AdvertisementRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->AdvertisementRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMyAdvertisements(Pagination $request)
    {
        $request->validated();
        return $this->AdvertisementRepo->myAdvertisement($request->take);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $advertisement = $request->validated();
        $advertisement['user_id'] = auth()->user()->id;
        if($request->hasFile('image')){
            $advertisement['image'] = $request->file('image')->store('advertisement');
        }
        $response = $this->AdvertisementRepo->create($advertisement);
        return response()->json([
            'success' => true,
            'message' => 'advertisement created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Advertisement  $Advertisement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->AdvertisementRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Advertisement  $Advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $advertisement = $request->validated();
        if($request->hasFile('image')){
            $advertisement['image'] = $request->file('image')->store('advertisement');
        }
        $this->AdvertisementRepo->update($id, $advertisement);
        return response()->json([
            'success' => true,
            'message' => 'advertisement updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Advertisement  $Advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(Advertisement $card)
    {
        $this->AdvertisementRepo->delete($card);
        return response()->json([
            'success' => true,
            'message' => 'card deleted successfully',
        ], Response::HTTP_OK);
    }
}
