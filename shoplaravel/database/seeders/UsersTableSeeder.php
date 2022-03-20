<?php

namespace Database\Seeders;
use App\Models\Admin;
use App\Models\Roles;
use DB;
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
        Admin::truncate();
        DB::table('admin_roles')->truncate();
        $adminRoles = Roles::where('name','admin')->first();
        $userRoles = Roles::where('name','user')->first();

        $admin = Admin::create([
            'admin_email' =>'corn@gmail.com',
            'admin_name' =>'corn',
            'admin_password'=>md5('772211'),
            'admin_phone'=>'0362269453'
        ]);
        $user = Admin::create([
            'admin_email' =>'candy@gmail.com',
            'admin_name' =>'candy',
            'admin_password'=>md5('772211'),
            'admin_phone'=>'0383900797'
        ]);
        $admin->roles()->attach($adminRoles);
        $user->roles()->attach($userRoles);

    }
}
