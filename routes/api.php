<?php

use Illuminate\Http\Request;

Route::get('led-on', function() {
    DB::table('leds')->where('id', '1')->update(['power' => 1]);
    $led = DB::table('leds')->where('id', '1')->first();
    return json_encode($led);
});

Route::get('led-off', function() {
    DB::table('leds')->where('id', '1')->update(['power' => 0]);
    $led = DB::table('leds')->where('id', '1')->first();
    return json_encode($led);
});

Route::get('led-status', function() {
    $led = DB::table('leds')->where('id', '1')->first();
    return [
      'led_status' => $led->power
    ];
});

Route::get('defaul-led', function() {
    DB::table('leds')->insert(
        array('power' => 0,)
    );
});