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
Route::middleware('api')->get('/me', 'Api\ApiController@me');
Route::middleware('api')->resource('/votes', 'Api\VoteController');
Route::middleware('api')->post('/options/{option}/vote', 'Api\OptionController@vote');
Route::middleware('api')->get('/votes/{vote}/voters', 'Api\VoteController@getVoters');
Route::middleware('api')->post('/images/store', 'Api\ImageController@store');
