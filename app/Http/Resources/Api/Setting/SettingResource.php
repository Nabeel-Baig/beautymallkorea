<?php

namespace App\Http\Resources\Api\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{

    final public function toArray($request): array|\JsonSerializable|\Illuminate\Contracts\Support\Arrayable
	{
        return parent::toArray($request);
    }
}
