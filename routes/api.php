<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\ShopController;
use App\Http\Controllers\Api\v1\RoleController;

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


Route::middleware('api')->prefix('v1')->group(function () {
    Route::post('/users/password/{id}',[\App\Http\Controllers\Api\v1\UserController::class,'changePsw']);
    Route::get('/users/detail/{id}',[\App\Http\Controllers\Api\v1\UserController::class,'detail']);
    Route::resource('users', UserController::class);
    Route::get('/roles',[\App\Http\Controllers\Api\v1\RoleController::class,'index']);
    Route::get('/shops/map-view',[\App\Http\Controllers\Api\v1\ShopController::class,'mapView']);
    Route::post('/shops/search',[\App\Http\Controllers\Api\v1\ShopController::class,'search']);
    
    Route::post('/shops/filter',[\App\Http\Controllers\Api\v1\ShopController::class,'filter']);
    Route::resource('shops', ShopController::class);
    
    Route::post('/auth/login',[\App\Http\Controllers\Api\v1\AuthController::class,'login']);
    Route::post('/auth/register',[\App\Http\Controllers\Api\v1\AuthController::class,'register']);
    Route::get('/auth/users',[\App\Http\Controllers\Api\v1\AuthController::class,'users']);
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
