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

//Route that sends a broker message
Route::post('/send-message', 'ServiceAController@index');

//Route that saves broker message to database
Route::post('/receive-message', 'ServiceBController@store');

//Route for exposing current balance and the time that was last updated
Route::get('/receive-message/balance', 'ServiceBController@show');
