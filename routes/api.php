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

Route::middleware('api')->namespace('Api')->group(function () {

    Route::prefix('auth')->post('/token', 'ApiController@token');

    Route::get('/me', 'ApiController@me');
    Route::resource('/votes', 'VoteController', ['except' => [
        'create', 'edit'
    ]]);
    Route::get('/votes/{vote}/voters', 'VoteController@getVoters');
    Route::post('/votes/{vote}/report', 'VoteController@report');
    Route::post('/options/{option}/vote', 'OptionController@vote');

    Route::post('/images/store', 'ImageController@store');
    Route::delete('/image', 'ImageController@destroy');
});
