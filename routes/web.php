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

if (env('APP_ENV') === 'production') {
	URL::forceScheme('https');
}

Route::get('/', 'GameController@home')->name('home');
Route::get('/play','GameController@play')->name('play');
Route::get('/rules','GameController@rules')->name('rules');

Route::post('/start','SecurityController@start');
Route::post('/end','SecurityController@end');
Route::put('/add/player','SecurityController@add_player')->name('update_user');

//Route::post('/add/facebook/player','SecurityController@add_fb_player');
//Route::post('/connect/facebook/player','SecurityController@fb');

Route::patch('/invite/friend/{player}','SecurityController@friend_invite')->name('friend_invite');
Route::get('/friend/{token}','SecurityController@friend_check')->name('friend_accepted');

Route::put('/second/play','SecurityController@second_play')->name('second_play');

Auth::routes();

Route::get('/settings', 'AdminController@index')->name('admin');
Route::patch('/update/periods','AdminController@periods')->name('update_periods');
Route::delete('/delete/player/{player}','AdminController@player')->name('delete_player');

Route::get('/excel','AdminController@playersToExcel')->name('excel');