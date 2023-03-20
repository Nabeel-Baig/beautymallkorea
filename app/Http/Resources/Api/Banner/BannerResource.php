<?php

namespace App\Http\Resources\Api\Banner;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{

    final public function toArray($request): array
	{
		return [
			'title' => $this->title,
			'link' => $this->link,
			'image' => $this->image,
		];
    }
}
