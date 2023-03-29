<?php

namespace App\Http\Resources\Api\QuickCategory;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuickCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}
