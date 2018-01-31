<?php

use Illuminate\Http\Request;

Route::get('led-on', function() {
    DB::table('leds')->where('id', '1')->update(['power' => 1]);
    $led = DB::table('leds')->where('id', '1');
    return $led->get();
});

Route::get('led-off', function() {
    DB::table('leds')->where('id', '1')->update(['power' => 0]);
    $led = DB::table('leds')->where('id', '1');
    return $led->get();
});

Route::get('led-status', function() {
    $led = DB::table('leds')->where('id', '1')->first();
    return [
      'led_status' => $led->power
    ];
});

Route::get('defaul-user', function() {
    DB::table('users')->insert(
        array('power' => 0,)
    );
});