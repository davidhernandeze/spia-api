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
            $response['max_humidity_' . $n] = $plant->max_humidity;
        }
        $lastUpdate = str_replace(' ', '%20', $response['last_setting_change']);
        $response['last_setting_change'] = $lastUpdate;
        return $response;
    }

    public function showForArduino(Device $device)
    {
        $response = collect($device);
        $n = 0;
        foreach ($device->plants as $plant) {
            $n++;
            $response['m' . $n] = $plant->max_humidity;
        }
        $lastUpdate = str_replace(' ', '%20', $response['last_setting_change']);
        $response['last_setting_change'] = $lastUpdate;
        return '{' . $response['automatic_mode'] . ','
            . $response['next_irrigation'] . ','
            . $response['watering_seconds'] . ','
            . $response['last_setting_change'] . ','
            . $response['m1'] . ','
            . $response['m2'] . '}';
    }

    public function update(Device $device, Request $request)
    {
        $device->update($request->all());
        if ($request['source'] == 'app') {
            $device->last_setting_change = Carbon::now()->toDateTimeString();
            $device->save();
        }
        return $device;
    }

    public function checkForUpdates(Device $device, Request $request)
    {
        $lastUpdate = $device->last_setting_change;
        $actualUpdate = $request['last_update'];
        $response = [
            'settings' => 'false',
            'pump' => $device->pump_requested
        ];
        if ($actualUpdate != $lastUpdate) {
            $response['settings'] = 'true';
        }
        if ($device->automatic_mode == 'on') {
            $response['pump'] = 'off';
        }
        return '{' . $response['settings'] . ', ' . $response['pump'] . '}';
    }

    public function pumpOn(Device $device)
    {
        if ($device->automatic_mode == 'on') {
            return response()->json(['error' => 'Manual mode is off']);
        }
        $device->pump_requested = 'on';
        $device->save();
        return response()->json(['success' => 'Pump on sent to Arduino']);
    }

    public function pumpOff(Device $device)
    {
        if ($device->automatic_mode == 'on') {
            return response()->json(['error' => 'Manual mode is off']);
        }
        $device->pump_requested = 'off';
        $device->save();
        return response()->json(['success' => 'Pump off sent to Arduino']);
    }

    public function pumpDone(Device $device)
    {
        $lastIrrigation = Carbon::now();
        if ($device->automatic_mode == 'off') {
            $device->last_irrigation = $lastIrrigation->toDateTimeString();
            $device->pump_requested = 'off';
            $device->save();
            return response()->json(['next_irrigation' => 'Manual mode active']);
        }
        $nextIrrigation = $lastIrrigation->copy()
            ->addHours($device->hours_to_repeat);
        $device->last_irrigation = $lastIrrigation->toDateTimeString();
        $device->next_irrigation = $nextIrrigation->toDateTimeString();
        $device->save();
        return response()->json(['next_irrigation' => $device->next_irrigation]);
    }

    public function updateFromArduino(Device $device, Request $request)
    {
        $device->update($request->all());
        return $device;
    }
}