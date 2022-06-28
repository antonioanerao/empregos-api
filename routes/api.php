<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyJobController;
use App\Http\Controllers\JobController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix'=>'auth'], function() {
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('auth.reset-password');
    Route::post('reset-password-with-token', [AuthController::class, 'resetPasswordWithToken'])->name('auth.reset-password-with-token');
});

Route::group(['prefix' => 'company'], function() {
    Route::resource('jobs',CompanyJobController::class)->except('create', 'edit', 'index');
});

Route::post('jobs', [JobController::class, 'index'])->name('jobs.index');
Route::post('jobs/{job}', [JobController::class, 'show'])->name('jobs.show');
