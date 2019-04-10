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

//ZASTICENE RUTE
Route::group(['middleware' => 'auth:api'], function() {
	
	
    Route::get('/user', function (Request $request) {
            return auth()->user();
    });

    Route::post('/articles', 'Api\\ArticlesController@index');
    Route::get('/article/{id}', 'Api\\ArticlesController@show');
    Route::post('/article/new', 'Api\\ArticlesController@store');
    Route::post('/article/{id}', 'Api\\ArticlesController@update');
    Route::post('/article/delete/{id}', 'Api\\ArticlesController@destroy');
    Route::get('/logout', 'Auth\LoginController@logout');
});

Route::post('/login','Api\\UserController@login');
Route::post('/token-regenerate','Api\\UserController@regenerateToken');

