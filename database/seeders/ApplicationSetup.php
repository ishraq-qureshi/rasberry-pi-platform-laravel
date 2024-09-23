<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class ApplicationSetup extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = Role::create(['name' => 'superadmin']);
        $admin = Role::create(['name' => 'admin']);
        $admin = Role::create(['name' => 'subadmin']);

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@yopmail.com',
            'password' => bcrypt("Adobe110#"),
            'surname' => "Mr",
            'telephone' => '123456789'
        ]);

        // Create an initial user and assign the superadmin role        
        $user->assignRole($superAdmin);
    }
}
