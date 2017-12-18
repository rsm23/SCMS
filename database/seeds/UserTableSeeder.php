<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin  = Role::where('name', 'admin')->first();
        $role_editor = Role::where('name', 'editor')->first();
        $role_subscriber  = Role::where('name', 'subscriber')->first();

        $employee = new User();
        $employee->name = 'Rahmani Saif El Moulouk';
        $employee->email = 'cool2309@gmail.com';
        $employee->password = bcrypt('password');
        $employee->save();
        $employee->roles()->attach($role_admin);

        $manager = new User();
        $manager->name = 'John Doe';
        $manager->email = 'editor@example.com';
        $manager->password = bcrypt('password');
        $manager->save();
        $manager->roles()->attach($role_editor);

        $manager = new User();
        $manager->name = 'Foo Bar';
        $manager->email = 'subscriber@example.com';
        $manager->password = bcrypt('password');
        $manager->save();
        $manager->roles()->attach($role_subscriber);
    }
}
