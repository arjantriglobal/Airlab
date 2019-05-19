<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Device;
use App\Blueprint;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $role = $user->role;
        $organizationid = $user->organization_id;

        //If admin
        if($role == 2){
            $devices = Device::where([
                ["organization_id", "!=", null],
                ["blueprint_id", "!=", null]
            ])->get();
    
            $blueprints = Blueprint::where([
                ["organization_id", "!=", null]
            ])->get();
        }else{
            $devices = Device::where([
                ["organization_id", "=", $organizationid],
                ["blueprint_id", "!=", null]
            ])->get();
    
            $blueprints = Blueprint::where([
                ["organization_id", "!=", $organizationid]
            ])->get();
        }
   
        return view('home', [
            "devices" => $devices, 
            "blueprints" => $blueprints
        ]);
    }
}
