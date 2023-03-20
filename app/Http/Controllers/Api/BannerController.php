<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Banner\BannerResource;
use App\Models\Banner;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BannerController extends Controller
{
    final public function index(string $type): ResourceCollection
	{
		$banners = Banner::select('title','link','image')->where('banner_type',$type)->latest('sort_order')->get();
		return BannerResource::collection($banners);
	}
}
