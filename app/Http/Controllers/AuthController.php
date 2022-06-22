<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserCandidateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\UserCandidate;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register', 'resetPassword', 'resetPasswordWithToken']]);
    }

    public function login(UserLoginRequest $request)
    {
        try {
            $token = auth('api')->attempt($request->only('email', 'password'));
        }catch(\Exception $exception) {
            return $exception->getMessage();
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

    public function register(UserRequest $userRequest, UserCandidateRequest $userCandidateRequest){
        DB::beginTransaction();
        try{
            $user = User::create([
                'name' => $userRequest->name,
                'email' => $userRequest->email,
                'password' => bcrypt($userRequest->password),
            ]);

            UserCandidate::create([
                'user_id' => $user->id,
                'type' => $userCandidateRequest->type
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

    // Make a method to allow a user reset their password and sent them an email with a link to reset their password
    public function resetPassword(Request $request){
        // Validate the request
        $request->validate([
            'email' => 'required|email',
        ]);

        // Find the user by their email
        $user = User::where('email', $request->email)->first();

        // If the user does not exist, return an error
        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist'
            ], 404);
        }

        // Generate a random string for the password reset token
        $token = STR::random(60);

        // Create a password reset token for the user
        $user->remember_token = $token;

        // Save the user
        $user->save();

        // Send the password by email
        event(new PasswordReset($user));

        // Return a success message
        return response()->json([
            'status' => 'success',
            'message' => 'Password reset email sent'
        ]);
    }

    public function resetPasswordWithToken(Request $request)
    {
        // Validate the request
        $request->validate([
            'token' => 'required',
            'password' => 'required'
        ]);

        // Find the user by their password reset token
        $user = User::where('remember_token', $request->token)->first();

        // If the token does not exist, return an error
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'This password reset token is invalid.'
            ], 404);
        }

        // Set the user's password
        $user->password = bcrypt($request->password);

        // Expire the remember_token
        $user->remember_token = null;

        // Save the user
        $user->save();

        // Return a success message
        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successfully'
        ]);
    }
}
