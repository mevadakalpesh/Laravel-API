<?php

use Illuminate\Http\Request;
use App\Http\Middleware\WeWantJson;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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




Route::post('/user-register',[PostController::class,'user_register']);
Route::post('/user-login',[PostController::class,'user_login']);

Route::group(['middleware' => ['auth:sanctum',WeWantJson::class]],function(){
    
    Route::get('/posts',[PostController::class,'posts']);
    Route::post('/add-post',[PostController::class,'add_post']);
    Route::delete('/remove-post/{id}',[PostController::class,'remove_post']);
    Route::put('/update-post/{id}',[PostController::class,'updated_post']);
});