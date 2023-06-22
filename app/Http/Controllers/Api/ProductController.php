<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ProductListQueryParamsRequest;
use App\Http\Resources\Api\Product\ProductDetailResource;
use App\Http\Resources\Api\Product\ProductListCollection;
use App\Models\Product;
use App\Services\Api\ProductApiService;

class ProductController extends Controller {
	public function __construct(private readonly ProductApiService $productApiService) {}

	final public function index(ProductListQueryParamsRequest $productListQueryParamsRequest): ProductListCollection {
		$products = $this->productApiService->productList($productListQueryParamsRequest);

		return new ProductListCollection($products);
	}

	final public function productDetails(Product $product): ProductDetailResource {
		$product = $this->productApiService->productDetails($product);

		return new ProductDetailResource($product);
	}
}
