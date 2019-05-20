<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Blueprint;
use Illuminate\Support\Facades\Auth;
use App\Models\Organization;
use App\Models\User;

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

        if($role == 2){
            $organizations = Organization::all();
        }else{
            $organizations = $user->organizations;
        }

        $organizationBlueprints = [];
        $blueprintMapper = (Object)[];
        $blueprintDevices = (Object)[];
        foreach($organizations as $organization){
            $organizationBlueprints[$organization->id] = $organization->blueprints;
            foreach($organizationBlueprints[$organization->id] as $blueprint){
                $blueprintMapper->{$blueprint->id} = $blueprint;
                $blueprintDevices->{$blueprint->id} = $blueprint->devices;
            }
        }
   
        return view('home', [
            "organizations" => $organizations,
            "organizationBlueprints" => $organizationBlueprints,
            "blueprintDevices" => $blueprintDevices,
            "blueprints" => $blueprintMapper
        ]);
    }
}
