<?php

namespace Database\Seeders;

use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder {
	final public function run(): void {
		$timestamp = Carbon::now()->toDateTimeString();

		$tags = ["lipstick", "nailpolish"];

		$tagRecords = array_map(static function (string $tagName) use ($timestamp) {
			return [
				"name" => $tagName,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}, $tags);

		Tag::insert($tagRecords);
	}
}
