<?php

namespace App\Http\Resources\Api\Banner;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Banner
 */
class BannerResource extends JsonResource {
	/**
	 * @param Request $request
	 *
	 * @return array
	 */
	final public function toArray(Request $request): array {
		return [
			"title" => $this->title,
			"link" => $this->link,
			"image" => $this->image,
		];
	}
}
