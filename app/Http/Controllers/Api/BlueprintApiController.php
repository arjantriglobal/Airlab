<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Blueprint;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BlueprintApiController extends Controller
{
    public function blueprint($id){
        return JsonResponse::create(Blueprint::find($id));
    }
    public function blueprints(){
        return JsonResponse::create(Blueprint::all());
    }
    public function devices($id){
        $blueprint = Blueprint::find($id);
        $devices = [];
        if(isset($blueprint)) $devices = $blueprint->devices; 
        return JsonResponse::create($devices);
    }
}
