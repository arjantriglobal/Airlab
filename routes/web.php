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
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@index')->name('profile');

Route::post('/profile/change', 'ProfileController@changeProfile')->name('changeProfile');
Route::post('/profile/adduser', 'ProfileController@addUser')->name('addUser');
Route::post('/profile/uploadblueprint', 'ProfileController@uploadBlueprint')->name('uploadBlueprint');

