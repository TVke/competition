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

Route::get('/', 'GameController@home')->name('game');
Route::get('/play','GameController@play')->name('play');

Auth::routes();

Route::get('/settings', 'AdminController@index')->name('admin');
