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
        $organizationid = $user->organization_id;

        if($role == 2){
            $organizations = Organization::all();
        }else{
            $organizations = Organization::where(["organization_id", "=", $organizationid])->get();
        }

        $organizationBlueprints = [];
        $blueprintMapper = (Object)[];
        $blueprintDevices = (Object)[];
        foreach($organizations as $organization){
            $blueprints = Blueprint::where([
                ["organization_id", "=", $organization->id]
            ])->get();
            $organizationBlueprints[$organization->id] = $blueprints;
            foreach($blueprints as $blueprint){
                $blueprintMapper->{$blueprint->id} = $blueprint;
                $blueprintDevices->{$blueprint->id} = Device::where([
                    ["organization_id", "=", $organization->id],
                    ["blueprint_id", "=", $blueprint->id]
                ])->get();
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
