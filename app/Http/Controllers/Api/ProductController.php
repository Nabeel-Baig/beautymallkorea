<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ProductListRequest;
use App\Http\Resources\Api\Product\ProductDetailResource;
use App\Http\Resources\Api\Product\ProductListCollection;
use App\Models\Product;
use App\Models\Tag;
use App\Services\Api\ProductApiService;

class ProductController extends Controller {
	public function __construct(private readonly ProductApiService $productApiService) {}

	final public function index(ProductListRequest $productListRequest): ProductListCollection {
		$products = $this->productApiService->productList($productListRequest);

		return new ProductListCollection($products);
	}

	final public function productDetails(Product $product): ProductDetailResource {
		$product = $this->productApiService->productDetails($product);

		return new ProductDetailResource($product);
	}

	final public function tagProducts(Tag $tag, ProductListRequest $productListRequest): ProductListCollection
	{
		$products = $this->productApiService->tagProductList($tag, $productListRequest);
		return new ProductListCollection($products);
	}
}
