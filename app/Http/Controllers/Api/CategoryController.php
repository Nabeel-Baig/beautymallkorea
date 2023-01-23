<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
	final public function index(): AnonymousResourceCollection
	{
		$categories = Category::select('id','name','description','meta_tag_title','meta_tag_description','meta_tag_keywords','slug','image')->whereNull('category_id')->with('childrenCategories')->orderBy('sort_order', 'asc')->get();
		return CategoryResource::collection($categories);
	}
}
