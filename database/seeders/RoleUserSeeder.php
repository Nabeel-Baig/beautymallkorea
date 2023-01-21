<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	final public function run(): void {
		User::findOrFail(1)->roles()->sync([1]);
		User::findOrFail(2)->roles()->sync([2]);
	}
}
