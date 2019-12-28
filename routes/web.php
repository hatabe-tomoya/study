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

if (version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

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

Route::group(['middleware' => 'auth'], function() {
    Route::resource('users','UsersController', ['only' => ['show', 'edit', 'update']] );
    
    //フォロー一覧を表示させるためのルート
    Route::get('users/{user}/follows_index', 'UsersController@followindex');
    //フォロワ一覧を表示させるためのルート
    Route::get('users/{user}/followers_index', 'UsersController@followerindex');
    //いいね一覧を表示させるためのルート
    Route::get('users/{user}/likes_index', 'UsersController@likeindex');
    
    
    
    Route::post('users/{user}/follow', 'UsersController@follow')->name('follow');
    Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('unfollow');
    
    Route::resource('posts', 'PostsController', ['only' => ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']]);
    
    Route::resource('comments', 'CommentsController', ['only' => ['store']]);
    
    Route::resource('likes', 'LikesController', ['only' => ['store', 'destroy']]);
});

