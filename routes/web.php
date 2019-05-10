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
use App\Adapters\uHooAdapter;

Route::get('/', function () {
  	return view('index');
});

Route::get("/getdevices", function () {
	return json_encode(uHooAdapter::GetDevices());
});

Route::get("/info", function () {
	phpinfo();
});
