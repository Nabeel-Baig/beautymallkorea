<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ProductListRequest;
use App\Http\Resources\Api\Category\CategoryListCollection;
use App\Http\Resources\Api\Category\CategoryResource;
use App\Http\Resources\Api\Product\ProductListCollection;
use App\Models\Category;
use App\Services\Api\CategoryApiService;

class CategoryController extends Controller {
	public function __construct(private readonly CategoryApiService $categoryApiService) {}

	final public function index(): CategoryListCollection {
		$categories = $this->categoryApiService->categoriesList();

		return new CategoryListCollection($categories);
	}

	public function getSingleCategory(string $slug): CategoryResource
	{
		$category = $this->categoryApiService->getSingleCategory($slug);
		return new CategoryResource($category);
	}

	final public function categoryProducts(Category $category, ProductListRequest $productListRequest): ProductListCollection {
		$products = $this->categoryApiService->categoryProductList($category, $productListRequest);

		return new ProductListCollection($products);
	}

}
