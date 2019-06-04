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

//Organizations
Route::get('/organizations', 'OrganizationController@index')->name('organizations');
Route::get('/organization/create', 'OrganizationController@create');
Route::post('/organization/create', 'OrganizationController@store');
Route::get('/organization/{organization_id}/edit', 'OrganizationController@edit');
Route::post('/organization/{organization_id}/edit', 'OrganizationController@update');
Route::get('/organization/{organization_id}/delete', 'OrganizationController@delete');

//Profile
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/profile/change', 'ProfileController@changeProfile')->name('changeProfile');
Route::post('/profile/adduser', 'ProfileController@addUser')->name('addUser');
Route::post('/profile/uploadblueprint', 'ProfileController@uploadBlueprint')->name('uploadBlueprint');

//Blueprints
Route::get('/blueprints', 'BlueprintController@index')->name('blueprints');
Route::get('/blueprint/create', 'BlueprintController@create');
Route::post('/blueprint/create', 'BlueprintController@store');
Route::get('/blueprint/{blueprint_id}/edit', 'BlueprintController@edit');
Route::post('/blueprint/{blueprint_id}/edit', 'BlueprintController@update');
Route::get('/blueprint/{blueprint_id}/delete', 'BlueprintController@delete');

//Devices
Route::get('/devices', 'DevicesController@index')->name('devices');

//Indicators
Route::get('/indicators', 'IndicatorController@index')->name('indicator');
Route::get('/indicator/{indicator_id}/edit', 'IndicatorController@edit');
Route::post('/indicator/{indicator_id}/edit', 'IndicatorController@update');

//Statuses
Route::get('/statuses', 'DeviceController@getStatuses')->name('statuses');
