<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DeviceApiController extends Controller
{
    public function device($id){
        return JsonResponse::create(Device::find($id));
    }

    public function devices(){
        return JsonResponse::create(Device::all());
    }

    public function lastrecord($id){
        $device = Device::find($id);
        $record = null;
        if(isset($device)) $record = $device->getLastRecord();
        return JsonResponse::create($record);
    }

    public function status($id){
        $device = Device::find($id);
        $status = null;
        if(isset($device)) $status = $device->getStatus();
        return JsonResponse::create($status);
    }

    public function positions(Request $request, $id){
        $device = Device::find($id);
        $updated = false;
        if(isset($device) && isset($request->x) && isset($request->y)){
            $device->left_pixel = $request->x;
            $device->top_pixel = $request->y;
            $device->save();
            $updated = true;
        }
        return JsonResponse::create($updated); 
    }

    public function changename(Request $request, $id){
        $device = Device::find($id);
        $updated = false;
        if(isset($device) && isset($request->name)){
            $device->update(['name' => $request->name]);
            $updated = true;
        }
        return JsonResponse::create($updated); 
    }
}
