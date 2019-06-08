<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()['cache']->forget('spatie.permission.cache');

        Permission::create(['name' => 'deploy servers']);
        Permission::create(['name' => 'manage servers']);
        Permission::create(['name' => 'upgrade servers']);
        Permission::create(['name' => 'manage snapshots']);
        Permission::create(['name' => 'manage iso']);
        Permission::create(['name' => 'manage startupscripts']);
        Permission::create(['name' => 'manage sshkeys']);
        Permission::create(['name' => 'manage dns']);
        Permission::create(['name' => 'manage backups']);
        Permission::create(['name' => 'manage blockstorage']);
        Permission::create(['name' => 'manage ips']);
        Permission::create(['name' => 'manage firewalls']);
        Permission::create(['name' => 'manage networks']);

        /* Permission::create(['name' => 'view dashboard']); */

        // create role and assign created permissions

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
