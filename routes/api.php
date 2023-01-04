<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\ProductController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/login',[AuthenticationController::class,'login']);

Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[AuthenticationController::class,'logout']);
    Route::resource('products',ProductController::class);
 
});
