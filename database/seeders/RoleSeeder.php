<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'delete articles', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'publish articles', 'guard_name' => 'sanctum']);
        Permission::create(['name' => 'unpublish articles', 'guard_name' => 'sanctum']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'writer', 'guard_name' => 'sanctum']);
        $role->givePermissionTo('edit articles');

        // or may be done by chaining
        $role = Role::create(['name' => 'moderator', 'guard_name' => 'sanctum'])
            ->givePermissionTo(['publish articles', 'unpublish articles']);

        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'sanctum']);
        $role->givePermissionTo(Permission::all());
    }
}
