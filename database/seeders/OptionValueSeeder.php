<?php

namespace Database\Seeders;

use App\Models\Option;
use App\Models\OptionValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OptionValueSeeder extends Seeder {
	final public function run(): void {
		$options = Option::all();
		$optionValues = [];
		$timestamp = Carbon::now()->toDateTimeString();

		foreach ($options as $option) {
			$optionValuePartialNames = ["1", "2", "3", "4", "5"];

			foreach ($optionValuePartialNames as $optionValue) {
				$eachOptionValue = [
					"option_id" => $option->id,
					"name" => "Option Value $option->id - $optionValue",
					"created_at" => $timestamp,
					"updated_at" => $timestamp,
				];

				$optionValues[] = $eachOptionValue;
			}
		}

		OptionValue::insert($optionValues);
	}
}
