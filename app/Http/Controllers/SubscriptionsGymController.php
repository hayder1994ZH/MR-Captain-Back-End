<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SubscriptionsGym;
use App\Http\Requests\Index\Pagination;
use App\Http\Requests\SubscriptionsGym\Create;
use App\Http\Requests\SubscriptionsGym\Update;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\SubscriptionsGymRepository;

class SubscriptionsGymController extends Controller
{
    private $SubscriptionsGymRepo;
    public function __construct(SubscriptionsGymRepository $SubscriptionsGymRepo)
    {
        $this->SubscriptionsGymRepo = $SubscriptionsGymRepo;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->SubscriptionsGymRepo->getList($request->take);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getMySubscriptions(Pagination $request)
    {
        $request->validated();
        return $this->SubscriptionsGymRepo->mySubscription($request->take);
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
            $cardNumberDate = $this->SubscriptionsGymRepo->getCard($subscription['card_id']);
            $subscription['start_date'] = Carbon::now();
            $subscription['expair_date'] = Carbon::now()->addDay($cardNumberDate);
        }
        $subscription['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->SubscriptionsGymRepo->create($subscription);
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
            $cardNumberDate = $this->SubscriptionsGymRepo->getCard($subscription['card_id']);
            $LastSubscripDate = $this->SubscriptionsGymRepo->getLastSubscrip($subscription['gym_id'])->expair_date;
            $subscription['start_date'] = $LastSubscripDate;
            $date = Carbon::createFromFormat('Y-m-d h:i:s', $LastSubscripDate);
            $subscription['expair_date'] = $date->addDays($cardNumberDate);
        }
        $subscription['gym_id'] = auth()->user()->gym->uuid;
        $response = $this->SubscriptionsGymRepo->create($subscription);
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
        return $this->SubscriptionsGymRepo->show($id);
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
            $cardNumberDate = $this->SubscriptionsGymRepo->getCard($subscription['card_id']);
            if($subscription['is_active']){
                $subscription['start_date'] = Carbon::now();
                $subscription['expair_date'] = Carbon::now()->addDay($cardNumberDate);
            }
        }
        $this->SubscriptionsGymRepo->update($id, $subscription);
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
    public function destroy(SubscriptionsGym $subscriptions)
    {
        $this->SubscriptionsGymRepo->delete($subscriptions);
        return response()->json([
            'success' => true,
            'message' => 'subscription deleted successfully',
        ], Response::HTTP_OK);
    }
}
