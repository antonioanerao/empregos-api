<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCandidateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\UserCandidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    public function login(UserLoginRequest $request)
    {
        $token = auth('api')->attempt($request->only('email', 'password'));

        if(!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized login attempt',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ],
            'user' => [
                'type' => auth()->user()->userType()->type
            ]
        ]);
    }

    public function register(UserRequest $userRequest, UserCandidateRequest $userInformationRequest){
        DB::beginTransaction();
        try{
            $user = User::create([
                'name' => $userRequest->name,
                'email' => $userRequest->email,
                'password' => bcrypt($userRequest->password),
            ]);

            UserCandidate::create([
                'user_id' => $user->id,
                'type' => $userInformationRequest->type
            ]);
            DB::commit();
        }catch(\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ], 201);
    }
}
