<?php
namespace App\Http\Controllers;

use App\Models\Blueprint;
use App\Models\Device;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController
{
    public function index()
    {
        $user = Auth::user();

        return view('device.index',
            [
                'user' => $user,
                'devices' => Device::all()
            ]);
    }

    public function edit($device_id)
    {
        $user = Auth::user();

        $device = Device::findOrFail($device_id);

        return view('device.edit', [
            'user' => $user,
            'device' => $device,
            'blueprints' => Blueprint::all(),
            'organizations' => Organization::all()
        ]);
    }

    public function update(Request $request, $device_id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $device = Device::findOrFail($device_id);
        $blueprint = Blueprint::find($request->blueprint);

        $device->name = $request->name;

        if (isset($blueprint))
        {
            $device->organization_id = $blueprint->organization_id;
            $device->blueprint_id = $request->blueprint;

        }
        else
        {
            $device->organization_id = null;
            $device->blueprint_id = null;
        }

        $device->updated_at = date("Y-m-d H:i:s");
        $device->save();

        return redirect('/devices');
    }

    public function getStatuses()
    {
        $user = Auth::user();

        $devices = Device::all();

        return view('statuses.index', [
            "user" => $user,
            "devices" => $devices
        ]);
    }
}