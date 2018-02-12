<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function init()
    {
        $device = new Device([
            'automatic_mode' => 'on',
            'hours_to_repeat' => 0,
            'temperature' => '12C',
            'next_irrigation' => '2018-02-14 05:52:56',
            'last_irrigation' => '2018-02-14 05:52:56',
            'watering_seconds' => '12',
            'last_setting_change' => '2018-02-14 05:52:56'
        ]);
        $device->save();
        return $device;
    }

    public function show(Device $device)
    {
        return $device;
    }

    public function update(Device $device, Request $request)
    {
        $device->update($request->all());
        return $device;
    }

    public function checkForUpdates(Device $device, Request $request)
    {
        $lastUpdate = $device->last_setting_change;
        $actualUpdate = $request['last_update'];

        if ($actualUpdate != $lastUpdate) {
           return "true";
        }
        return "false";
    }
}
