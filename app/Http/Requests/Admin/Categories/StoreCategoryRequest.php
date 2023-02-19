<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreCategoryRequest extends FormRequest {
	final public function authorize(): bool {
		abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		return true;
	}

	final public function rules(): array {
		return [
			'category_id' => ['nullable', 'integer'],
			'name' => ['required', 'string','unique:categories'],
			'description' => ['nullable', 'string'],
			'meta_tag_title' => ['nullable', 'string'],
			'meta_tag_description' => ['nullable', 'string'],
			'meta_tag_keywords' => ['nullable', 'string'],
			'sort_order' => ['required', 'integer'],
			'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png'],
		];
	}
}
