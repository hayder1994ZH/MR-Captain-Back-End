<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\Login;
use Illuminate\Support\Facades\DB;
use App\Repositories\GymRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\Register;
use App\Repositories\AuthRepository;
use App\Http\Requests\Auth\RegisterAdmin;
use App\Http\Requests\Auth\UpdateProfile;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    private $authRepo;
    private $gymRepo;
    public function __construct(AuthRepository $authRepo, GymRepository $gymRepo)
    {
        $this->authRepo = $authRepo;
        $this->gymRepo = $gymRepo;
    }
 
    //Login
    public function login(Login $request)
    {
        $credentials = $request->validated();
        $response = $this->authRepo->authenticate($credentials);
        return response()->json($response[0], $response['code']);
    }

    //Registeration
    public function register(Register $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $data['rule_id'] = 5;
        $user = $this->authRepo->create($data);
        $response = $this->authRepo->authenticate([
            'phone' => $data['phone'],
            'password' => $request->password
        ]);
        return response()->json($response[0], $response['code']);
    }

    //Registeration
    public function registerAdmin(RegisterAdmin $request)
    {
        $data = $request->validated();
        //validations gym
        $gym = $request->validate([
            'gym_name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'city_id' => 'required|integer|exists:cities,id',
        ]);
        DB::beginTransaction();//start transaction
        try {
            $data['password'] = bcrypt($request->password);
            $data['rule_id'] = 2;
            $gym['uuid'] =  Str::uuid();
            $gym['name'] = $request->gym_name;
            $newGym = $this->gymRepo->create($gym);
            $data['gym_id'] = $newGym->uuid;
            $this->authRepo->create($data);
            $response = $this->authRepo->authenticate([
                'phone' => $data['phone'],
                'password' => $request->password
            ]);
        } catch(\Exception $e)
        {
            DB::rollback();//rollback transaction if exception
            throw $e;
        }

        DB::commit();//commit transaction if no exception
        return response()->json($response[0], $response['code']);
    }

    //Update Profile
    public function update(UpdateProfile $request)
    {
        $data = $request->validated();
        $user = auth()->user();
        if($request->has('password')){
            $data['password'] = bcrypt($request->password);
        }
        if($request->hasFile('image')){
            $data['image'] = $request->file('image')->store('avatars');
        }
        $this->authRepo->update($user->id, $data);
        return response()->json([
            'success' => true,
            'message' => 'Profile created successfully',
            'data' => $user
        ], Response::HTTP_OK);
    }
 
    //Logout
    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json([
            'message' => 'logout succssfully',
        ]);
    }
 
    //User auth information
    public function details()
    {
        return auth()->user()->load('rule', 'gym', 'city.country');
    }
}