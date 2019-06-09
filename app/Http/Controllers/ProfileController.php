<?php
/**
 * Created by PhpStorm.
 * User: Marco de Coninck
 * Date: 16-5-2019
 * Time: 14:03
 */

namespace App\Http\Controllers;

use App\Models\Blueprint;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $organizations_list = [];

        foreach (Organization::all() as $organization)
        {
            $organizations_list[$organization->id] = $organization->name;
        }

        $user = Auth::user();

        return view('profile.index',
        [
            'user' => $user,
            'users' => User::all(),
            'organizations' => $organizations_list
        ]);
    }

    public function addUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'organization' => 'required',
            'role' => 'required',
            'password' => 'required',
        ]);


        $user = new User();

        $user->role = $request->role;
        $user->organization_id = $request->organization;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");

        $user->save();

        return redirect('/profile');
    }

    public function changeProfile(Request $request, $admin_account = true)
    {
        //Get the user
        $user = User::where("id", "=", $request->user)->first();

        $request->validate([
            'email' => 'unique:users',
        ]);

        //Change user fields

        if ($admin_account === true)
        {
            if (!empty($request->organization))
                $user->organization_id = $request->organization;

            if (!empty($request->role))
                $user->role = $request->role;
        }

        if (!empty($request->name))
            $user->name = $request->name;

        if (!empty($request->email))
            $user->email = $request->email;

        if (!empty($request->password))
            $user->password = Hash::make($request->password);

        $user->updated_at = date("Y-m-d H:i:s");

        //Save user and redirect to profile page.
        $user->save();

        return redirect('/profile');
    }
}