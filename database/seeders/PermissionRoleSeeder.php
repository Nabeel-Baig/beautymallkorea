<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $master_admin_permissions = Permission::all();
        $admin_permissions = $master_admin_permissions->filter(function ($permission) {
            return $permission->title != 'user_management_access' && substr($permission->title, 0, 5) != 'role_' && substr($permission->title, 0, 11) != 'permission_';
        });

        Role::findOrFail(1)->permissions()->sync($master_admin_permissions->pluck('id'));
        Role::findOrFail(2)->permissions()->sync($admin_permissions);
    }
}
