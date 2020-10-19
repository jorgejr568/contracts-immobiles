<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\ImmobileController;
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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/', [AuthController::class, 'me']);
});

Route::apiResource('immobile', ImmobileController::class)
    ->only('index', 'store', 'destroy')
    ->middleware('jwt.auth');

Route::apiResource('immobile.contract', ContractController::class)
    ->only('store')
    ->middleware('jwt.auth');
