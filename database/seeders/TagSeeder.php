<?php

namespace Database\Seeders;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder {
	final public function run(): void {
		$timestamp = Carbon::now()->toDateTimeString();
		$tags = [];

		for ($index = 1; $index <= 500; $index++) {
			$identifier = str_pad($index, 3, "0", STR_PAD_LEFT);

			$tags[] = [
				"name" => "Tag $identifier",
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}

		Tag::insert($tags);
	}
}
