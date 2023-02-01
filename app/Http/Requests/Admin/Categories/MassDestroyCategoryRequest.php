<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCategoryRequest extends FormRequest {
	final public function authorize(): bool {
		abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
		return true;
	}

	final public function rules(): array {
		return [
			'ids' => 'required|array',
			'ids.*' => 'exists:categories,id',
		];
	}
}
