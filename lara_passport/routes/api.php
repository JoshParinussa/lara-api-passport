<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfilesController;
use App\Http\Controllers\SkillsController;
use App\Http\Controllers\UserController;
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

Route::middleware('accessToken', 'auth:api')->get('/user', function (Request $request) {
    error_log('Some message here.');
    // die(dd($request->headers));
    return $request->user();
});

Route::post('login', [LoginController::class, 'login']);
Route::post('register', [UserController::class, 'store']);
// Route::get('user', function (Request $request) {
//     error_log('Get User.'.$request->user());
//     return $request->user();
// })->middleware('accessToken');
Route::middleware('accessToken', 'auth:api')->get('/testing', [LoginController::class, 'testing']);
// Route::get('testing', [LoginController::class, 'testing'])->middleware('accessToken');

// Route::post('users', [UserController::class, 'store']);
// Route::get('users', [UserController::class, 'index']);
// Route::get('users', [UserController::class, 'show']);
Route::apiResource('users', UserController::class)->middleware('auth:api');

Route::apiResource('skills', SkillsController::class)->middleware('auth:api');
Route::apiResource('profiles', ProfilesController::class)->middleware('auth:api');
Route::apiResource('activities', ActivitiesController::class)->middleware('auth:api');