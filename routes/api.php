<?php

use Illuminate\Http\Request;

Route::get('/devices/create_main_device', 'DeviceController@init');
Route::get('/devices/{device}', 'DeviceController@show');
Route::patch('/devices/{device}', 'DeviceController@update');

Route::get('/devices/{device}/pump-on', 'DeviceController@pumpOn');
Route::get('/devices/{device}/pump-done', 'DeviceController@pumpDone');

Route::get('/devices/{device}/check-for-updates', 'DeviceController@checkForUpdates');


Route::get('/devices/{device}/plants', 'PlantController@index');
Route::get('/plants/{plant}', 'PlantController@show');
Route::patch('/plants/{plant}', 'PlantController@update');
