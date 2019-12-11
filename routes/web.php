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
    return view('top');
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('post/create', 'Admin\PostController@add');
    Route::get('user/create', 'Admin\UserController@add');
    Route::get('user/edit', 'Admin\UserController@edit');
    Route::post('post/create', 'Admin\PostController@create');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
