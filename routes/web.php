<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', "App\Http\Controllers\HomeController@index")->name('home');

Route::post('register/pre_check', 'App\Http\Controllers\Auth\RegisterController@pre_check')->name('register.pre_check');
Route::get('register/pre_complete', 'App\Http\Controllers\Auth\RegisterController@pre_complete')->name('register.pre_complete');
Route::get('register/verify/{token}', 'App\Http\Controllers\Auth\RegisterController@showForm');
Auth::routes();

