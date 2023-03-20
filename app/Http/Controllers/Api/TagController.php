<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Product\ProductListQueryParamsRequest;
use App\Http\Resources\Api\Product\ProductListCollection;
use App\Models\Tag;
use App\Services\Api\TagApiService;

class TagController extends Controller {
	public function __construct(private readonly TagApiService $tagApiService) {}

	final public function tagProducts(Tag $tag, ProductListQueryParamsRequest $productListQueryParamsRequest): ProductListCollection {
		$products = $this->tagApiService->tagProductList($tag, $productListQueryParamsRequest);

		return new ProductListCollection($products);
	}
}
