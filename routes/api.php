<?php

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\StudentController;
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

// all student api route
Route::post('register',[StudentController::class,'register']);
Route::post('login',[StudentController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']],function(){

    Route::get('profile',[StudentController::class,'profile']);
    Route::get('logout',[StudentController::class,'logout']);

    // project all route
    Route::post('create-project',[ProjectController::class,'create']);
    Route::get('project-list',[ProjectController::class,'listProject']);
    Route::get('single-project/{id}',[ProjectController::class,'singleProject']);
    Route::put('update-project/{id}',[ProjectController::class,'update']);
    Route::delete('delete-project/{id}',[ProjectController::class,'delete']);


});
