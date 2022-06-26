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

Route::get('/', "App\Http\Controllers\TaskController@index")->name('task.index');
Route::middleware(["auth"])->group(function(){
    Route::get('/create', "App\Http\Controllers\TaskController@create")->name('task.create');
    Route::get('/edit/{id}', "App\Http\Controllers\TaskController@edit")->name('task.edit');
    Route::post('/store', "App\Http\Controllers\TaskController@store")->name('task.store');
    Route::post('/update/{id}', "App\Http\Controllers\TaskController@update")->name('task.update');
    Route::post('/delete/{id}', "App\Http\Controllers\TaskController@delete")->name('task.delete');
});


Route::get('register/pre_complete', 'App\Http\Controllers\Auth\RegisterController@pre_complete')->name('register.pre_complete');
Route::get('register/verify/{token}', 'App\Http\Controllers\Auth\RegisterController@showForm');
Route::post('register/pre_check', 'App\Http\Controllers\Auth\RegisterController@pre_check')->name('register.pre_check');

Auth::routes();

