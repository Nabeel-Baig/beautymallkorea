<?php

namespace Database\Seeders;

use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder {
	final public function run(): void {
		$timestamp = Carbon::now()->toDateTimeString();
		$optionNames = ["Option 1", "Option 2", "Option 3", "Option 4", "Option 5"];

		$tags = array_map(static function (string $optionName) use ($timestamp) {
			return [
				"name" => $optionName,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}, $optionNames);

		Option::insert($tags);
	}
}
