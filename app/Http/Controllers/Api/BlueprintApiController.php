<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Models\Blueprint;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Illuminate\Auth\Access\Response;

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
    public function changeName(Request $request, $id){
        $newname = $request->name;
        $blueprint = Blueprint::find($id);
        if(isset($blueprint) && isset($newname)){
            $blueprint->name = $newname;
            $blueprint->save();
            return JsonResponse::create(true);
        }
        return JsonResponse::create(false);
    }
    public function delete($id){
        $blueprint = Blueprint::find($id);
        if(isset($blueprint)){
            $blueprint->delete();
            return JsonResponse::create(true);
        }
        return JsonResponse::create(false);
    }
}
