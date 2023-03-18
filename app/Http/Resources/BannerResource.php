<?php

namespace App\Http\Resources;

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
