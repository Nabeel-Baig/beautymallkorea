<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Seed the application's database.
	 *
	 * @return void
	 */
	public function run() {
		// \App\Models\User::factory(10)->create();
		$this->call([
			SettingsSeeder::class,
			UserSeeder::class,
			PermissionSeeder::class,
			RoleSeeder::class,
			PermissionRoleSeeder::class,
			RoleUserSeeder::class,
			CategorySeeder::class,
			TagSeeder::class,
			OptionSeeder::class,
			OptionValueSeeder::class,
		]);
	}
}
