<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Plant;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index(Device $device)
    {
        return $device->plants;
    }

    public function show (Plant $plant)
    {
        return $plant;
    }

    public function update(Plant $plant, Request $request)
    {
        $plant->update($request->all());
        if($request['source'] == 'app') {
            $device = $plant->device;
            $device->last_setting_change = Carbon::now()->toDateTimeString();
            $device->save();
        }
        return $plant;
    }
}
