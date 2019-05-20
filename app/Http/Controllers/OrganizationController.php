<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    /**
     * Method to get organizations
     * @return [type] [description]
     */
    public function getOrganizations(){
        return Organization::all();
    }

    public function index()
    {
        $user = Auth::user();

        return view('organization.index',
            [
                'user' => $user,
                'organizations' => Organization::all()
            ]);
    }

    public function create()
    {
        $user = Auth::user();

        return view('organization.create',
            [
                'user' => $user
            ]);
    }

    public function store(Request $request)
    {
        $organization = new Organization();

        $organization->name = $request->name;
        $organization->created_at = date("Y-m-d H:i:s");
        $organization->updated_at = date("Y-m-d H:i:s");

        $organization->save();

        return redirect('/organizations');
    }

    public function edit($organization_id)
    {
        $user = Auth::user();

        $organization = Organization::findOrFail($organization_id);

        return view('organization.edit',
            [
                'user' => $user,
                'organization' => $organization
            ]);
    }

    public function update(Request $request, $organization_id)
    {
        $organization = Organization::findOrFail($organization_id);

        $organization->name = $request->name;
        $organization->updated_at = date("Y-m-d H:i:s");

        $organization->save();

        return redirect('/organizations');
    }

    public function delete($organization_id)
    {
        $organization = Organization::findOrFail($organization_id);

        $organization->delete();

        return redirect('/organizations');
    }
}
