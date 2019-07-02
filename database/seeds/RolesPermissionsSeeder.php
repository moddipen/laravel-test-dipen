<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Super admin Permissions
     *
     * @var array
     */
    protected $superPermissions = [
        'Club list',
        'Club create',
        'Club delete',
        'User list',
        'User create',
        'User delete',
        'Login other',
    ];

    /**
     * Club admin Permissions
     *
     * @var array
     */
    protected $clubPermissions = [
        'Team create',
        'Team edit',
        'Team delete',
        'Team list',
        'Player group create',
        'Player group edit',
        'Player group delete',
        'Player group list',
        'Player create',
        'Player edit',
        'Player delete',
        'Player list',
    ];

    /**
     * Roles
     *
     * @var array
     */
    protected $roles = [
        'Super admin',
        'Club admin'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        app()['cache']->forget('spatie.permission.cache');

        foreach ($this->superPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($this->clubPermissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        foreach ($this->roles as $name) {
            $role = Role::create(['name' => $name]);
            if ($name == 'Super admin') {
                $role->syncPermissions($this->superPermissions);
            } else {
                $role->syncPermissions($this->clubPermissions);
            }
        }
    }
}
