<?php
/**
 * Created by PhpStorm.
 * User: Marco de Coninck
 * Date: 16-5-2019
 * Time: 14:03
 */

namespace App\Http\Controllers;

use App\Organization;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = User::all();

        $organizations = Organization::all();
        dd($organizations);
        $user = Auth::user();
        return view('profile.index',
        [
            'user' => $user,
            'profiles' => $profiles,
            'organizations' => $organizations
        ]);
    }
}