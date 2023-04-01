<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\QuickCategory\QuickCategoryResource;
use App\Models\QuickCategory;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuickCategoryController extends Controller {
	final public function index(): ResourceCollection {
		$quickCategories = QuickCategory::select('name', 'image', 'link')->orderBy('sort_order', 'asc')->get();
		return QuickCategoryResource::collection($quickCategories);
	}
}
