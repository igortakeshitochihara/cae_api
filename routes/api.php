<?php

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

Route::get('/', function (Request $request) {
    $date = new DateTime;
    $now = $date->format('Y-m-d H:i:s');
    return $request->json(200, ['message' => 'Server work :) :) :)' . $now]);
});

Route::post('register', ['uses' => 'App\Http\Controllers\AuthController@register']);
Route::post('login', ['uses' => 'App\Http\Controllers\AuthController@login']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'key'], function () {
        Route::post('/', ['uses' => 'App\Http\Controllers\KeyController@add']);
        Route::get('/', ['uses' => 'App\Http\Controllers\KeyController@list']);
        Route::put('/', ['uses' => 'App\Http\Controllers\KeyController@update']);
        Route::delete('/{hash}', ['uses' => 'App\Http\Controllers\KeyController@remove']);
    });

    Route::group(['prefix' => 'room'], function () {
        Route::post('/', ['uses' => 'App\Http\Controllers\RoomController@add']);
        Route::get('/', ['uses' => 'App\Http\Controllers\RoomController@list']);
        Route::put('/', ['uses' => 'App\Http\Controllers\RoomController@update']);
        Route::delete('/{hash}', ['uses' => 'App\Http\Controllers\RoomController@remove']);
    });

    Route::group(['prefix' => 'borrowing'], function () {
        Route::post('/{hash}', ['uses' => 'App\Http\Controllers\BorrowingController@borrowing']);
        Route::put('/{hash}', ['uses' => 'App\Http\Controllers\BorrowingController@return']);
    });
});