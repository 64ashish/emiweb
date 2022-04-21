<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

//        create permissions for users
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'update users']);
        Permission::create(['name' => 'delete users']);

//        create permissions for archives
        Permission::create(['name' => 'create archives']);
        Permission::create(['name' => 'view archives']);
        Permission::create(['name' => 'update archives']);
        Permission::create(['name' => 'delete archives']);

//        create permissions for categories
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);

//        create permissions for organizations
        Permission::create(['name' => 'create organizations']);
        Permission::create(['name' => 'view organizations']);
        Permission::create(['name' => 'update organizations']);
        Permission::create(['name' => 'delete organizations']);

//        create permissions for roles
        Permission::create(['name' => 'create roles']);
        Permission::create(['name' => 'view roles']);
        Permission::create(['name' => 'update roles']);
        Permission::create(['name' => 'delete roles']);

//        create permissions for permissions
        Permission::create(['name' => 'create permissions']);
        Permission::create(['name' => 'view permissions']);
        Permission::create(['name' => 'update permissions']);
        Permission::create(['name' => 'delete permissions']);

//        super admin [full access]
        Role::create(['name' => 'super admin']);

//        emiweb roles [full access to users, organizations and the migration data]
        Role::create(['name' => 'emiweb admin'])
            ->givePermissionTo(['view users', 'create users', 'update users','delete users',
                'view organizations','create organizations','delete organizations', 'update organizations', 'view roles',
                'view permissions', 'view categories', 'view archives', 'update archives']);
        Role::create(['name' => 'emiweb staff'])
            ->givePermissionTo(['view users', 'update users', 'view organizations', 'update organizations', 'view categories',
                'view archives', 'update archives']);

//        organization roles [read and update access to data belonging to their organization, i.e users, organization, migration data]
        Role::create(['name' => 'organization admin'])
            ->givePermissionTo(['view users', 'update users', 'view organizations', 'update organizations', 'view archives', 'update archives']);

        Role::create(['name' => 'organization staff'])
            ->givePermissionTo(['view users', 'update users', 'view organizations', 'view archives', 'update archives']);
//         subscribers
        Role::create(['name' => 'subscriber'])
            ->givePermissionTo(['view users', 'update users', 'view archives']);
//         regular user
        Role::create(['name' => 'regular user'])
            ->givePermissionTo(['view users', 'update users', 'view archives']);


//        assign permissions for roles

    }
}
