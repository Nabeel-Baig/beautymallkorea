<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GeneralResource extends JsonResource
{

    final public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
	{
        return parent::toArray($request);
    }
}
