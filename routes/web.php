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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::post('activate/{id}','UserController@activate')->name('activate');
    Route::post('suspend/{id}','UserController@suspend')->name('suspend');
    Route::post('comment','CommentsController@store')->name('comment');
    Route::post('download','PostController@download')->name('download');
    Route::get('category_chart','PostController@category')->name('category_chart');

    Route::get('admin','UserController@admin')->name('admin');
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::resource('post','PostController');
    Route::resource('category','CategoryController');
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);
});


Route::group(['middleware' => 'auth'], function () {
	Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);
});

