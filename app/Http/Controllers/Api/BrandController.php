<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Brand\BrandListRequest;
use App\Http\Requests\Api\Product\ProductListRequest;
use App\Http\Resources\Api\Brand\BrandListCollection;
use App\Http\Resources\Api\Brand\BrandResource;
use App\Http\Resources\Api\Product\ProductListCollection;
use App\Models\Brand;
use App\Services\Api\BrandApiService;

class BrandController extends Controller {
	public function __construct(private readonly BrandApiService $brandApiService) {}

	final public function index(BrandListRequest $brandListRequest): BrandListCollection {
		$brands = $this->brandApiService->brandList($brandListRequest);

		return new BrandListCollection($brands);
	}

	public function getSingleBrand(string $slug): BrandResource
	{
		$brand = $this->brandApiService->getSingleBrand($slug);
		return new BrandResource($brand);
	}

	final public function brandWithProducts(): BrandListCollection {
		$brands = $this->brandApiService->brandWithProductList();

		return new BrandListCollection($brands);
	}

	final public function brandProducts(Brand $brand, ProductListRequest $productListRequest): ProductListCollection {
		$products = $this->brandApiService->brandProductList($brand, $productListRequest);

		return new ProductListCollection($products);
	}
}
