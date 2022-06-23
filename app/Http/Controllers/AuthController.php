<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResetPasswordWithTokenRequest;
use App\Http\Requests\UserCandidateRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\UserCandidate;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

    public function resetPassword(Request $request){
        $request->validate([
            'email' => 'required|email',
            'url-back' => 'required|url'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist'
            ], 404);
        }

        $token = STR::random(60);
        $url_back = $request['url-back'];

        DB::beginTransaction();
        try{
            $passwordReset = DB::table('password_resets')->select('email')->where('email', $request->email)->first();

            if($passwordReset) {
                DB::table('password_resets')->where('email', $request->email)->update([
                    'token' => $token,
                    'url-back' => $request['url-back'],
                    'created_at' => now()
                ]);
            } else {
                DB::table('password_resets')->insert([
                    'email' => $user->email,
                    'token' => $token,
                    'url-back' => $request['url-back'],
                    'created_at' => now()
                ]);
            }
            Mail::send('emails.reset-password', ['token' => $token, 'url_back' => $url_back, 'user' => $user], function ($m) use ($token, $url_back, $user) {
                $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
                $m->to($user->email, $user->name)->subject('Reset your password');
            });
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
            'message' => 'Password reset email sent'
        ]);
    }

    public function resetPasswordWithToken(ResetPasswordWithTokenRequest $request)
    {
        $resetPassword = DB::table('password_resets')
            ->select('email', 'token')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if(!$resetPassword) {
            return response()->json([
                'status' => 'error',
                'message' => 'This password reset token is invalid.'
            ], 404);
        }


        DB::beginTransaction();
        try{
            $user = User::where('email', $request->email)->first();

            $user->password = bcrypt($request->password);
            $user->save();

            DB::table('password_resets')->where('email', $request->email)->delete();
            DB::commit();
        }catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Password reset successfully'
        ]);
    }
}
