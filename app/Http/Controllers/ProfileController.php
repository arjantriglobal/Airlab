<?php
/**
 * Created by PhpStorm.
 * User: Marco de Coninck
 * Date: 16-5-2019
 * Time: 14:03
 */

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
}