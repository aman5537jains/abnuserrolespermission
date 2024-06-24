<?php

namespace AbnCms\RolesPermission;

use AbnCms\RolesPermission\Models\Permission;
use AbnCms\RolesPermission\Models\Role;
use AbnCms\RolesPermission\Models\UserRole;
use Aman5537jains\AbnCms\Lib\AbnCms;
use App\Models\User;
use Harimayco\Menu\Models\Menus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Do you wish to refresh migration before seeding, it will clear all old data ?')) {
            // Call the php artisan migrate:refresh
            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");
        }



        $role = Role::firstOrCreate(['name' => "Super Admin"]);

        $this->command->info('Super Admin Role Created');
        $pass  = \Illuminate\Support\Str::random(5);
        $user = $this->createUser($pass);

        $this->command->info('Super Admin  Created');

        UserRole::create(["user_id"=>$user->id,"role_id"=>$role->id]);

        $this->command->info('Super Admin Role Assigned');

        // Seed the default permissions
        $permissions = AbnCms::defaultPermissions();

        Permission::addPermissions($permissions);


        $this->command->info('Default Permissions added and assigned to super admin.');


        $this->command->info('Here is your admin details to login:');
        $this->command->warn($user->email);
        $this->command->warn('Password is "'.$pass.'"');


        $this->command->info('Creating Sidebar....');
        AbnCms::createDefaultAdminSidebar();



        // Confirm roles needed
        // if ($this->command->confirm('Create Roles for user, default is admin and user? [y|N]', true)) {

        //     // Ask for roles from input
        //     $input_roles = $this->command->ask('Enter roles in comma separate format.', 'Admin,User');

        //     // Explode roles
        //     $roles_array = explode(',', $input_roles);

        //     // add roles
        //     foreach($roles_array as $role) {
        //         $role = Role::firstOrCreate(['name' => trim($role)]);

        //         if( $role->name == 'Admin' ) {
        //             // assign all permissions
        //             $role->syncPermissions(Permission::all());
        //             $this->command->info('Admin granted all the permissions');
        //         } else {
        //             // for others by default only read access
        //             $role->syncPermissions(Permission::where('name', 'LIKE', 'view_%')->get());
        //         }

        //         // create one user for each role
        //         $this->createUser($role);
        //     }

        //     $this->command->info('Roles ' . $input_roles . ' added successfully');

        // } else {
        //     Role::firstOrCreate(['name' => 'User']);
        //     $this->command->info('Added only default user role.');
        // }


    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser($pass)
    {
        return  User::create(["name"=>"Super Admin","email"=>"admin@yopmail.com","password"=>bcrypt($pass)]);

    }
}
