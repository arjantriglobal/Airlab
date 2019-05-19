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
        $user = new User();

        $user->role = $request->role_id;
        $user->organization_id = $request->organization_id;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->created_at = date("Y-m-d H:i:s");
        $user->updated_at = date("Y-m-d H:i:s");

        $user->save();

        return redirect('/profile');
    }

    public function changeProfile(Request $request)
    {
        //Get the user
        $user = User::where("id", "=", $request->user_id)->first();

        //Change user fields
        if (!empty($request->organization_id))
            $user->organization_id = $request->organization_id;

        if (!empty($request->role_id))
            $user->role = $request->role_id;

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

    public function uploadBlueprint(Request $request)
    {
        // Handle File Upload
        if($request->hasFile('uploaded_file')) {
            // Get filename with extension
            $filenameWithExt = $request->file('uploaded_file')->getClientOriginalName();

            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);

            // Get just ext
            $extension = $request->file('uploaded_file')->getClientOriginalExtension();

            //Filename to store
            $fileNameToStore = $filename.'.'.$extension;

            // Store the file
            $path = $request->file('uploaded_file')->storeAs('storage/', $fileNameToStore);
        }

        // Create a User using User model
        $blueprint = new Blueprint();

        $blueprint->name = $request->name;
        $blueprint->organization_id = $request->organization_id;
        $blueprint->path = str_replace("//", "/", $path);
        $blueprint->created_at = date("Y-m-d H:i:s");
        $blueprint->updated_at = date("Y-m-d H:i:s");

        $blueprint->save();

        return redirect('/profile');
    }
}