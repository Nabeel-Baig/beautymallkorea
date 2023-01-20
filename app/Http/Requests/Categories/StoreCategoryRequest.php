<?php

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreCategoryRequest extends FormRequest
{
    final public function authorize(): bool
    {
		abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN,'403 Forbidden');
        return true;
    }

    final public function rules(): array
    {
        return [
            'type' => ['required','string'],
            'category_id' => ['sometimes','required','integer'],
            'name' => ['required','string'],
            'description' => ['sometimes','required','string'],
			'meta_tag_title' => ['sometimes','required','string'],
			'meta_tag_description' => ['sometimes','required','string'],
			'meta_tag_keywords' => ['sometimes','required','string'],
            'sort_order' => ['required','integer'],
            'image' => ['sometimes','required','image','mimes:jpg,jpeg,png'],
        ];
    }
}
