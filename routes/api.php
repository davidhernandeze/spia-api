<?php

use Illuminate\Http\Request;

Route::get('/devices/create_main_device', 'DeviceController@init');
Route::get('/devices/{device}', 'DeviceController@show');
Route::patch('/devices/{device}', 'DeviceController@update');
Route::get('/devices/{device}/check-for-updates', 'DeviceController@checkForUpdates');


Route::get('/devices/{device}/plants/{plant}', 'PlantController@show');
Route::get('/devices/{device}/plants', 'PlantController@index');
Route::patch('/devices/{device}/plants/{plant}', 'PlantController@update');
