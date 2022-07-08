<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests\Index\Pagination;
use App\Http\Requests\Subscription\Create;
use App\Http\Requests\Subscription\Update;
use App\Repositories\CardsRepository;
use App\Repositories\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    private $SubscriptionRepo;
    private $CardRepo;
    public function __construct(SubscriptionRepository $SubscriptionRepo, CardsRepository $CardsRepo)
    {
        $this->SubscriptionRepo = $SubscriptionRepo;
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
        return $this->SubscriptionRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMySubscriptions(Pagination $request)
    {
        $request->validated();
        return $this->SubscriptionRepo->mySubscription($request->take, $request->current_day, $request->player_not_expaired, $request->player_expaired);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $subscription = $request->validated();
        if($subscription['is_active']){
            $cardNumberDate = $this->SubscriptionRepo->getCard($subscription['card_id']);
            $subscription['start_date'] = Carbon::now();
            $subscription['expair_date'] = Carbon::now()->addDay($cardNumberDate);
        }
        $subscription['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->SubscriptionRepo->create($subscription);
        return response()->json([
            'success' => true,
            'message' => 'subscription created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeSubscripAboutLastSUbscription(Create $request)
    {
        $subscription = $request->validated();
        if($subscription['is_active']){
            $cardNumberDate = $this->SubscriptionRepo->getCard($subscription['card_id']);
            $LastSubscripDate = $this->SubscriptionRepo->getLastSubscrip($subscription['player_id'])->expair_date;
            $subscription['start_date'] = $LastSubscripDate;
            $date = Carbon::createFromFormat('Y-m-d h:i:s', $LastSubscripDate);
            $subscription['expair_date'] = $date->addDays($cardNumberDate);
        }
        $subscription['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->SubscriptionRepo->create($subscription);
        return response()->json([
            'success' => true,
            'message' => 'subscription created successfully',
            'data' => $response

        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->SubscriptionRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $subscription = $request->validated();
        if($request->has('is_active')){
            $cardNumberDate = $this->SubscriptionRepo->getCard($subscription['card_id']);
            if($subscription['is_active']){
                $subscription['start_date'] = Carbon::now();
                $subscription['expair_date'] = Carbon::now()->addDay($cardNumberDate);
            }
        }
        $this->SubscriptionRepo->update($id, $subscription);
        return response()->json([
            'success' => true,
            'message' => 'subscription updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subscription  $Subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        $this->SubscriptionRepo->delete($subscription);
        return response()->json([
            'success' => true,
            'message' => 'subscription deleted successfully',
        ], Response::HTTP_OK);
    }
}
