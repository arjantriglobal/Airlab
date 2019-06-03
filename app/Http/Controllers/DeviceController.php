<?php
namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Support\Facades\Auth;

class DeviceController
{
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