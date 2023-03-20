<?php

namespace App\Services\Api;

use App\Http\Requests\Api\Product\ProductListQueryParamsRequest;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TagApiService {
	public function __construct(private readonly ProductApiService $productApiService) {}

	final public function tagProductList(Tag $tag, ProductListQueryParamsRequest $productListQueryParamsRequest): Collection|LengthAwarePaginator {
		$productListBuilder = $this->productApiService->createProductListBuilder($productListQueryParamsRequest);

		$productListBuilder = $this->applySpecificTagFilter($tag, $productListBuilder);

		return $this->productApiService->buildProductListResult($productListBuilder, $productListQueryParamsRequest);
	}

	final public function applySpecificTagFilter(Tag $tag, Builder $productListBuilder): Builder {
		return $productListBuilder->whereHas("tags", static function (Builder $tagQuery) use ($tag) {
			$tagQuery->where("tags.slug", "=", $tag->slug);
		});
	}
}
