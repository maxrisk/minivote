<?php

use Illuminate\Http\Request;

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

Route::middleware('api')->prefix('auth')->post('/token', 'Api\ApiController@token');
Route::middleware('api')->get('/test', 'Api\ApiController@test');
Route::middleware('api')->post('/test', 'Api\ApiController@test');
