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
Route::get('/', function () {
    if(auth()->user()){
        return view('spa');
    }else{
        return redirect('/login');
    }

});
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
