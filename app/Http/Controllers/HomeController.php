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
        $organizations = [];

        if($role == 2){
            $organizations  = Organization::all();
        }else{
            $organizations[] = $user->organization;
        }

        $blueprints = [];
        foreach($organizations as $organization){
            foreach($organization->blueprints as $blueprint){
                $blueprints[] = $blueprint;
            }
        }
   
        return view('home', ["organizations" => $organizations, "blueprints" => $blueprints, "user" => $user]);
    }
}
