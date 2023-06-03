<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ExpenseController;
use App\Http\Controllers\MailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/oauth', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UserController::class);
Route::post('login', [UserController::class, 'login']);


Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('logout', [UserController::class, 'logout']);
    Route::apiResource('expenses', ExpenseController::class);
    Route::get('oauth', [UserController::class, 'oauthUser']);
});
