<?php

namespace Database\Seeders;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->toDateTimeString();
        $level1 = Category::create([
            'name' => 'Skin Care',
            'slug' => 'skin-care',
            'meta_tag_title' => 'Skin Care',
            'sort_order' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        for ($i = 1; $i < 4; $i++) {
            $level2 = Category::create([
                'category_id' => $level1->id,
                'name' => 'Skin Care SC-' . $i .'-' .$level1->id,
                'slug' => 'skin-care-sc' . $i .'-' .$level1->id,
                'meta_tag_title' => 'Skin Care SC-' . $i .'-' .$level1->id,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
            for ($j = 1; $j < 8; $j++) {
                Category::create([
                    'category_id' => $level2->id,
                    'name' => 'Skin Care SSC-' . $j . $j . '-' .$level2->id,
                    'slug' => 'skin-care-ssc' . $j . '-' .$level2->id,
                    'meta_tag_title' => 'Skin Care SSC-' . $j . '-' .$level2->id,
                    'sort_order' => $j,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }

        $level1 = Category::create([
            'name' => 'Make Up',
            'slug' => 'make-up',
            'meta_tag_title' => 'Make Up',
            'sort_order' => 2,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        for ($i = 1; $i < 4; $i++) {
            $level2 = Category::create([
                'category_id' => $level1->id,
                'name' => 'Make Up SC-' . $i .'-' .$level1->id,
                'slug' => 'make-up-sc' . $i .'-' .$level1->id,
                'meta_tag_title' => 'Make Up SC-' . $i .'-' .$level1->id,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
            for ($j = 1; $j < 8; $j++) {
                Category::create([
                    'category_id' => $level2->id,
                    'name' => 'Make Up SSC-' . $j . $j . '-' .$level2->id,
                    'slug' => 'make-up-ssc' . $j . $j . '-' .$level2->id,
                    'meta_tag_title' => 'Make Up SSC-' . $j . $j . '-' .$level2->id,
                    'sort_order' => $j,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }
        }

        $level1 = Category::create([
            'name' => 'Face Treatment',
            'slug' => 'face-treatment',
            'meta_tag_title' => 'Face Treatment',
            'sort_order' => 4,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        for ($i = 1; $i < 4; $i++) {
            $level2 = Category::create([
                'category_id' => $level1->id,
                'name' => 'Face Treatment SC-' . $i .'-' .$level1->id,
                'slug' => 'face-treatment-sc' . $i .'-' .$level1->id,
                'meta_tag_title' => 'Face Treatment SC-' . $i .'-' .$level1->id,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        $level1 = Category::create([
            'name' => 'Body/Hair',
            'slug' => 'bodyhair',
            'meta_tag_title' => 'Body/Hair',
            'sort_order' => 5,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        for ($i = 1; $i < 4; $i++) {
            $level2 = Category::create([
                'category_id' => $level1->id,
                'name' => 'Body/Hair SC-' . $i .'-' .$level1->id,
                'slug' => 'bodyhair-sc' . $i .'-' .$level1->id,
                'meta_tag_title' => 'Body/Hair SC-' . $i .'-' .$level1->id,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        $level1 = Category::create([
            'name' => 'Derma',
            'slug' => 'derma',
            'meta_tag_title' => 'Derma',
            'sort_order' => 6,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        for ($i = 1; $i < 4; $i++) {
            $level2 = Category::create([
                'category_id' => $level1->id,
                'name' => 'Derma SC-' . $i .'-' .$level1->id,
                'slug' => 'derma-sc' . $i .'-' .$level1->id,
                'meta_tag_title' => 'Derma SC-' . $i .'-' .$level1->id,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }

        $level1 = Category::create([
            'name' => 'Shop By Skin Type',
            'slug' => 'shop-by-skin-type',
            'meta_tag_title' => 'Shop By Skin Type',
            'sort_order' => 7,
            'created_at' => $now,
            'updated_at' => $now
        ]);
        for ($i = 1; $i < 4; $i++) {
            $level2 = Category::create([
                'category_id' => $level1->id,
                'name' => 'Shop By Skin Type SC-' . $i .'-' .$level1->id,
                'slug' => 'shop-by-skin-type-sc' . $i .'-' .$level1->id,
                'meta_tag_title' => 'Shop By Skin Type SC-' . $i .'-' .$level1->id,
                'sort_order' => $i,
                'created_at' => $now,
                'updated_at' => $now
            ]);
        }
    }
}
