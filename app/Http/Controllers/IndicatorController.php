<?php

namespace App\Http\Controllers;


use App\Models\Device;
use App\Models\Indicator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndicatorController
{
    public function index()
    {
        $user = Auth::user();
        $devices_list = [];

        $devices = Device::all();

        foreach ($devices as $dev)
        {
            $devices_list[$dev->id] = $dev->name;
        }

        return view('indicator.index',
            [
                'user' => $user,
                'indicators' => Indicator::all(),
                'devices' => $devices_list
            ]);
    }

    public function edit($indicator_id)
    {
        $user = Auth::user();

        $indicator = Indicator::findOrFail($indicator_id);

        return view('indicator.edit',
            [
                'user' => $user,
                'indicator' => $indicator,
                'devices' => Device::all()
            ]);
    }

    public function update(Request $request, $indicator_id)
    {
        $request->validate([
            'name' => 'required',
            'device' => 'required'
        ]);

        $indicator = Indicator::findOrFail($indicator_id);

        $indicator->name = $request->name;
        $indicator->device_id = $request->device;
        $indicator->updated_at = date("Y-m-d H:i:s");

        $indicator->save();

        return redirect('/indicators');
    }

}