<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Plant;
use Carbon\Carbon;
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
        $plant = new Plant([
            'device_id' => $device->id,
            'humidity' => "0",
            'max_humidity' => "0",
        ]);
        $plant->save();

        $plant = new Plant([
            'device_id' => $device->id,
            'humidity' => "0",
            'max_humidity' => "0",
        ]);
        $plant->save();

        return $device;
    }

    public function show(Device $device)
    {
        $response = collect($device);
        $n = 0;
        foreach ($device->plants as $plant) {
            $n++;
            $response['max_humidity_'.$n] = $plant->max_humidity;
        }
        return $response;
    }

    public function update(Device $device, Request $request)
    {
        $device->update($request->all());
        if($request['source'] == 'app') {
            $device->last_setting_change = Carbon::now()->toDateTimeString();
            $device->save();
        }
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

    public function updateLast (Device $device)
    {
        $lastIrrigation = Carbon::now();
        $nextIrrigation = $lastIrrigation->copy()
            ->addHours($device->hours_to_repeat);
        $device->last_irrigation = $lastIrrigation->toDateTimeString();
        $device->next_irrigation = $nextIrrigation->toDateTimeString();
        $device->save();
        return response()->json(['next_irrigation' => $device->next_irrigation]);
    }
}
