<?php

namespace App\Http\Resources\Api\Product;

use App\Http\Resources\Api\Brand\BrandResource;
use App\Http\Resources\Api\Category\CategoryListCollection;
use App\Http\Resources\Api\Tag\TagListCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductDetailResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray($request): array {
		return [
			"name" => $this->name,
			"slug" => $this->slug,
			"description" => $this->description,
			"meta_title" => $this->meta_title,
			"meta_description" => $this->meta_description,
			"meta_keywords" => $this->meta_keywords,
			"sku" => $this->sku,
			"upc" => $this->upc,
			"price" => $this->price,
			"discount_price" => $this->discount_price,
			"quantity" => $this->quantity,
			"image" => $this->image,
			"secondary_images" => $this->secondary_images,
			"min_order_quantity" => $this->min_order_quantity,
			"promotion_status" => $this->promotion_status,

			"relatedProducts" => new ProductListCollection($this->whenLoaded("relatedProducts")),
			"brand" => new BrandResource($this->whenLoaded("brand")),
			"tags" => new TagListCollection($this->whenLoaded("tags")),
			"categories" => new CategoryListCollection($this->whenLoaded("categories")),
		];
	}
}
