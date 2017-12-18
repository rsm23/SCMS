<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_manager              = new Role();
        $role_manager->name        = 'admin';
        $role_manager->description = 'An Administrator User';
        $role_manager->save();

        $role_employee              = new Role();
        $role_employee->name        = 'editor';
        $role_employee->description = 'An Editor User';
        $role_employee->save();

        $role_employee              = new Role();
        $role_employee->name        = 'subscriber';
        $role_employee->description = 'An Subscriber User';
        $role_employee->save();
    }
}
