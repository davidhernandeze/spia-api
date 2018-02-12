<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
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
