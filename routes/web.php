<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware('auth')->namespace('Admin')->group(function () {

    Route::get('/', function() {
        return redirect()->route('login');
    });
    
    
    
    //Articles routes
    
    Route::get('/articles/list', 'ArticlesController@index')->name('articles.index');
    Route::get('/article/create', 'ArticlesController@create')->name('articles.create');
    Route::get('/article/{id}', 'ArticlesController@singleArticle')->name('article.single');
    Route::get('/article/edit/{id}', 'ArticlesController@edit')->name('article.edit');
    Route::post('/article/update/{id}', 'ArticlesController@update')->name('article.update');
    Route::get('/delete-media/image/{id}', 'ArticlesController@deleteImage');
    
    
    //Profile routes    
    Route::get('/profile/edit','ProfileController@edit')->name('profile.edit');
    Route::post('/profile/edit','ProfileController@update');
    Route::get('/profile/change-password','ProfileController@changePassword')->name('profile.change-pasword');
    Route::post('/profile/change-password','ProfileController@updatePassword');
    
    
    
    
});