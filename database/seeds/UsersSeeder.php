<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->name = 'Super Admin';
        $admin->email = 'admin1@yopmail.com';
        $admin->password = bcrypt('admin@123');
        $admin->save();
        $admin->assignRole(['Super Admin']);
    }
}
