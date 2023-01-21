<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	final public function run(): void {
		$timestamp = Carbon::now()->toDateTimeString();

		$permissions = array_map(static function (PermissionEnum $permissionEnum) use ($timestamp) {
			return [
				'title' => $permissionEnum->value,
				'created_at' => $timestamp,
				'updated_at' => $timestamp,
			];
		}, PermissionEnum::cases());

		Permission::insert($permissions);
	}
}
