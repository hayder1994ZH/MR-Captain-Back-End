<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\Admin;
use App\Http\Requests\User\Create;
use App\Http\Requests\User\Update;
use App\Http\Requests\User\Captain;
use App\Repositories\UserRepository;
use Illuminate\Auth\Events\Validated;
use App\Http\Requests\Index\Pagination;
use App\Http\Requests\User\Player;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    private $UserRepo;
    public function __construct(UserRepository $UserRepo)
    {
        $this->UserRepo = $UserRepo;
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
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('avatars');
        }
        $response = $this->UserRepo->create($data);
        return response()->json($response, 200);
    }
}
