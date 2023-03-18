<?php

namespace Database\Seeders;

use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{

	public function run(): void
	{
		$timestamp = Carbon::now()->toDateTimeString();
		$sliders = [];
		for ($i = 1; $i < 7; $i++) {
			$sliders [] = [
				'banner_type' => 'slider',
				'title' => 'slider'.$i,
				'link' => 'javascript:;',
				'image' => "images/banners/slider$i.jpg",
				'sort_order' => $i,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}
		Banner::insert($sliders);

		$promotion_events = [];
		for ($i = 1; $i < 5; $i++) {
			$promotion_events [] = [
				'banner_type' => 'promotion_event',
				'title' => 'promotion_event'.$i,
				'link' => 'javascript:;',
				'image' => "images/banners/promotion_event$i.jpg",
				'sort_order' => $i,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}
		Banner::insert($promotion_events);

		$promotion_brands = [];
		for ($i = 1; $i < 5; $i++) {
			$promotion_brands [] = [
				'banner_type' => 'promotion_brand',
				'title' => 'promotion_brand'.$i,
				'link' => 'javascript:;',
				'image' => "images/banners/promotion_brand$i.jpg",
				'sort_order' => $i,
				"created_at" => $timestamp,
				"updated_at" => $timestamp,
			];
		}
		Banner::insert($promotion_brands);

		Banner::create([
			'banner_type' => 'delivery_banner',
			'title' => 'delivery_banner',
			'link' => 'javascript:;',
			'image' => "images/banners/delivery_banner.jpg",
			'sort_order' => $i,
			"created_at" => $timestamp,
			"updated_at" => $timestamp,
		]);
	}
}
