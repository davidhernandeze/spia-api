<?php

use Illuminate\Http\Request;

Route::get('/devices/create_main_device', 'DeviceController@init');
Route::get('/devices/{device}', 'DeviceController@show');
Route::get('/devices/{device/patch', 'DeviceController@updateFromArduino');
Route::get('/devices/arduino/{device}', 'DeviceController@showForArduino');
Route::patch('/devices/{device}', 'DeviceController@update');

Route::get('/devices/{device}/pump-on', 'DeviceController@pumpOn');
Route::get('/devices/{device}/pump-off', 'DeviceController@pumpOff');
Route::get('/devices/{device}/pump-done', 'DeviceController@pumpDone');

Route::get('/devices/{device}/check-for-updates', 'DeviceController@checkForUpdates');


Route::get('/devices/{device}/plants', 'PlantController@index');
Route::get('/plants/{plant}', 'PlantController@show');
Route::patch('/plants/{plant}', 'PlantController@update');

Route::get('test', function () {
    return [
        'am' => 'a',
        'ni' => 'a',
        'ws' => 'a',
        'ls' => 'a',
        'm1' => 'a',
        'm2' => 'a',
    ];
});