<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	final public function run(): void {
		$master_admin_permissions = Permission::all();
		$admin_permissions = $master_admin_permissions->filter(function ($permission) {
			return $permission->title !== 'user_management_access' && !str_starts_with($permission->title, 'role_') && !str_starts_with($permission->title, 'permission_');
		});

		Role::findOrFail(1)->permissions()->sync($master_admin_permissions->pluck('id'));
		Role::findOrFail(2)->permissions()->sync($admin_permissions);
	}
}
