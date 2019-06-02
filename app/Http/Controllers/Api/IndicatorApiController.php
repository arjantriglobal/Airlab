<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Indicator;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class IndicatorApiController extends Controller
{
    public function indicator($macaddress){
        return JsonResponse::create(Indicator::where('mac_address', "=", $macaddress)->first());
    }

    public function indicators(){
        return JsonResponse::create(Indicator::all());
    }

    public function status($macaddress){
        $indicator = Indicator::where('mac_address', "=", $macaddress)->first();
        if(!isset($indicator)){
            $indicator = new Indicator();
            $indicator->name = $macaddress;
            $indicator->mac_address = $macaddress;
            $indicator->save();
        }
        return JsonResponse::create($indicator->getDeviceStatus());
    }
}
