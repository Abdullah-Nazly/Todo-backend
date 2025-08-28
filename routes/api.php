<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('todos', TodoController::class);

Route::post('signup', [AuthController::class, 'signup']);

Route::post('login', [AuthController::class, 'login']);

Route::group([
    'middleware' => 'api',
], function ($router) {

    // Route::post('logout', 'AuthController@logout');
    // Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class, 'me']);

});