<?php

namespace Database\Seeders;

use App\Models\Quickcategory;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuickcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
		$quickCategories = [
			[
				'name' => 'SKINCARE',
				'image' => 'images/quickcategories/main_cote1_off.png',
				'link' => 'javascript:void(0)',
				'sort_order' => 1,
				"created_at" => $now,
				"updated_at" => $now,
			],
			[
				'name' => 'MAKEUP',
				'image' => 'images/quickcategories/main_cote2_off.png',
				'link' => 'javascript:void(0)',
				'sort_order' => 2,
				"created_at" => $now,
				"updated_at" => $now,
			],
			[
				'name' => 'HAIR & BODY',
				'image' => 'images/quickcategories/main_cote3_off.png',
				'link' => 'javascript:void(0)',
				'sort_order' => 3,
				"created_at" => $now,
				"updated_at" => $now,
			],
			[
				'name' => 'MASK TRIAL KIT',
				'image' => 'images/quickcategories/main_cote4_off.png',
				'link' => 'javascript:void(0)',
				'sort_order' => 4,
				"created_at" => $now,
				"updated_at" => $now,
			],
			[
				'name' => 'DEVICES & TOOLS',
				'image' => 'images/quickcategories/main_cote5_off.png',
				'link' => 'javascript:void(0)',
				'sort_order' => 5,
				"created_at" => $now,
				"updated_at" => $now,
			]
		];
		Quickcategory::insert($quickCategories);
    }
}
