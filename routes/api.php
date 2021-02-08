<?php

use App\Http\Controllers\CovidController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('users/invite', [UserController::class, 'processInvites']);
});

Route::post('register', [UserController::class, 'register']);

Route::post('login', [UserController::class, 'login']);

Route::get('get-all', [UserController::class, 'getDeneme']);

Route::get('get-usa', [CovidController::class, 'getTurkey']);
Route::get('get-finance', [CovidController::class, 'getFinance']);
