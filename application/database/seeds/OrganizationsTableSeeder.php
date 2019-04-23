<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Organization;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = Organization::where("name", "=", "Da Vinci College")->get();
        if(count($organizations) == 0){
            $organization = new Organization();
            $organization->name = "Da Vinci College";
            $organization->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $organization->save();
        }
    }
}
