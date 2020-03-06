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

Route::middleware('auth')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::resource('posts', 'PostController')->middleware('auth');
Route::get('users/profile', 'UserController@profile')->name('users.profile')->middleware('auth');
Route::resource('users', 'UserController')->middleware('auth');
Route::post('posts/{post}/','PostController@deleteImage')->name('posts.deleteImage')->middleware('auth');
