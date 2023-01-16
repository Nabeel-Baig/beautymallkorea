<?php

namespace App\Http\Requests\categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
		abort_if(Gate::denies('category_create'), Response::HTTP_FORBIDDEN,'403 Forbidden');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => ['required','string'],
            'category_id' => ['required','integer'],
            'name' => ['required','string'],
            'description' => ['sometimes','required','string'],
            'sort_order' => ['required','integer'],
            'image' => ['sometimes','required','image','mimes:jpg,jpeg,png'],
        ];
    }
}
