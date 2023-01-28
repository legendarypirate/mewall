<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {
    Route::post('/login', 'UserController@login');
    Route::post('/register', 'UserController@register');
    Route::post('/acc', 'UserController@acc');
    Route::post('/createp', 'UserController@createp');
    Route::post('/time', 'UserController@time');
    Route::post('/stop', 'UserController@stop');
        Route::post('/updt', 'UserController@updt');
        Route::post('/upacc', 'UserController@upacc');
    Route::get('/lt/{id}', 'UserController@lt');
    Route::get('/data/{id}', 'UserController@data');

    Route::get('/dayvalue/{id}', 'UserController@dayvalue');
    Route::post('/auto', 'UserController@auto');
    Route::get('/image', 'UserController@image');
    Route::get('/lott', 'UserController@lott');
    Route::get('/lotts', 'UserController@lotts');
    Route::get('/sett', 'UserController@sett');
    Route::get('/slider', 'UserController@slider');
    Route::get('/quart', 'UserController@quart');

});

