<?php

use App\Models\User;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add default admin user if this not already exists.
        $users = User::where("email", "=", "admin@mail.nl")->get();
        if(count($users) == 0){
            $admin = new User();
            $admin->name = "Admin";
            $admin->email = "admin@mail.nl";
            $admin->password = Hash::make("123admin");
            $admin->role = 2;
            $admin->created_at = Carbon::now()->format('Y-m-d H:i:s');

            $organizations = Organization::where("name", "=", "Da Vinci College")->get();
            if(count($organizations) > 0){
                $admin->organization_id = $organizations[0]->id;
                $admin->save();
            }
        }

        //Add default user if this not already exists.
        $users = User::where("email", "=", "user@mail.nl")->get();
        if(count($users) == 0){
            $admin = new User();
            $admin->name = "User";
            $admin->email = "user@mail.nl";
            $admin->password = Hash::make("123user");
            $admin->role = 1;
            $admin->created_at = Carbon::now()->format('Y-m-d H:i:s');

            $organizations = Organization::where("name", "=", "Da Vinci College")->get();
            if(count($organizations) > 0){
                $admin->organization_id = $organizations[0]->id;
                $admin->save();
            }
        }
    }
}
