<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Welcome to ' . config('app.name') . ' API'
    ]);
});

Route::get('/test', function() {
   // Return all data from table password_resets
    $password_resets = DB::table('password_resets')->get();
    return response()->json($password_resets);
});
