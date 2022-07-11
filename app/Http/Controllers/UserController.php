<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\User\Admin;
use App\Http\Requests\User\Create;
use App\Http\Requests\User\Player;
use App\Http\Requests\User\Update;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\User\Captain;
use App\Repositories\UserRepository;
use App\Http\Requests\Index\Pagination;
use App\Repositories\SubscriptionRepository;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $UserRepo;
    private $SubscriptionRepo;
    public function __construct(UserRepository $UserRepo, SubscriptionRepository $SubscriptionRepo)
    {
        $this->UserRepo = $UserRepo;
        $this->SubscriptionRepo = $SubscriptionRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Pagination $request)
    {
        $request->validated();
        return $this->UserRepo->getList($request->take);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAdminsOrCaptainsGym(Pagination $request)
    {
        $request->validated();
        return $this->UserRepo->getListMyGymAdminsAndCaptains($request->take);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPlayersGym(Pagination $request)
    {
        $request->validated();
        return $this->UserRepo->getListMyGymPlayers($request->take, $request->current_day, $request->player_not_expaired, $request->player_expaired, $request->player_has_debt);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Create $request)
    {
        $user = $request->validated();
        $user['password'] = bcrypt($request->password);
        if($request->hasFile('image')){
            $user['image'] = $request->file('image')->store('avatars');
        }
        return $this->UserRepo->create($user);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePlayerWithSubscription(Player $request)
    {
        $user = $request->validated();
        //validations subscription
        $subscription = $request->validate([
            'card_id' => 'required|integer|exists:cards,id',
        ]);
        DB::beginTransaction();//start transaction
        try {
            $user['password'] = bcrypt($request->password);
            $user['rule_id'] = 5;
            if($request->hasFile('image')){
                $user['image'] = $request->file('image')->store('avatars');
            }
            $user =  $this->UserRepo->create($user);
            $cardNumberDate = $this->SubscriptionRepo->getCard($subscription['card_id']);
            if(!$cardNumberDate){
                return response()->json([
                    'success' => false,
                    'message' => 'card not found',
                ], Response::HTTP_BAD_REQUEST);
            }
            $subscription['start_date'] = Carbon::now();
            $subscription['expair_date'] = Carbon::now()->addDay($cardNumberDate->days);
            $subscription['gym_id'] = auth()->user()->gym->uuid;
            $subscription['player_id'] = $user['id'];
            $subscription['is_active'] = 1;
            $this->SubscriptionRepo->create($subscription);
        } catch(\Exception $e)
        {
            DB::rollback();//rollback transaction if exception
            throw $e;
        }
        DB::commit();//commit transaction if no exception
        return response()->json([
            'success' => true,
            'message' => 'Player created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->UserRepo->show($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $user = $request->validated();
        if($request->has('password')){
            $user['password'] = bcrypt($user['password']);
        }
        if($request->hasFile('image')){
            $user['image'] = $request->file('image')->store('avatars');
        }
        $this->UserRepo->update($id, $user);
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->UserRepo->delete($user);
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], Response::HTTP_OK);
    }

    public function getMyGymUsers(Pagination $request)
    {
        $request->validated();
        return $this->UserRepo->getListMyGym($request->take);
    }
    
    //Registeration Captain
    public function addCaptain(Captain $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['rule_id'] = 3;
        $data['gym_id'] = auth()->user()->gym->uuid;
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('avatars');
        }
        $response = $this->UserRepo->create($data);
        return response()->json($response, 200);
    }
    
    //Registeration Player
    public function addPlayer(Player $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['rule_id'] = 5;
        $data['gym_id'] = auth()->user()->gym->uuid;
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('avatars');
        }
        $response = $this->UserRepo->create($data);
        return response()->json($response, 200);
    }
    
    //Registeration Player
    public function addAdmin(Admin $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['rule_id'] = 2;
        $data['gym_id'] = auth()->user()->gym->uuid;
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('avatars');
        }
        $response = $this->UserRepo->create($data);
        return response()->json($response, 200);
    }

    /**
     * Remove player from gym.
     *
     * @param  \App\Models\Models\User  $User
     * @return \Illuminate\Http\Response
     */
    public function RemovePlayerFromGym($id)
    {
        $checkPlayerExists =  $this->UserRepo->checkIfPlayerInMyGym($id);
        if(!$checkPlayerExists){
            return response()->json([
                'success' => false,
                'message' => 'Player not found',
            ], Response::HTTP_BAD_REQUEST);
        }
        $this->UserRepo->LogoutFromGym($id);
        return response()->json([
            'success' => true,
            'message' => 'Player logout successfully',
        ], Response::HTTP_OK);
    }
}
