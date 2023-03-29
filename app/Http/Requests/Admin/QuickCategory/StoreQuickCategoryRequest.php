<?php

namespace App\Http\Requests\Admin\QuickCategory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreQuickCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
		abort_if(Gate::denies('quick_category_create'), Response::HTTP_FORBIDDEN,'403 Forbidden');
        return true;
    }
    public function rules(): array
    {
        return [
			"name" => "required|string",
			"image" => "required|image",
			"link" => "required|url",
			"sort_order" => "required|numeric",
        ];
    }
}
