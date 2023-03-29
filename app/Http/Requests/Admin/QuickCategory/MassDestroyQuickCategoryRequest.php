<?php

namespace App\Http\Requests\Admin\QuickCategory;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyQuickCategoryRequest extends FormRequest
{
	public function authorize(): bool
	{
		abort_if(Gate::denies(PermissionEnum::QUICK_CATEGORY_DELETE->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		return true;
	}

	public function rules(): array
	{
		return [
			'ids' => 'required|array',
			'ids.*' => 'exists:quickcategories,id',
		];
	}
}
