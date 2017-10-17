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

Route::get('/', 'GameController@home')->name('home');
Route::get('/play','GameController@play')->name('play');
Route::get('/rules','GameController@rules')->name('rules');

Route::post('/start','GameController@start');
Route::post('/end','GameController@end');
Route::put('/add/player','GameController@add_player')->name('update_user');

Route::get('/test',function(\Illuminate\Http\Request $request){
	$request->getClientIp();
//	return hash_algos();
	return hash("md5",$request->getClientIp());
});

Auth::routes();

Route::get('/settings', 'AdminController@index')->name('admin');
