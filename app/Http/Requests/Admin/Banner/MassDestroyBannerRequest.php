<?php

namespace App\Http\Requests\Admin\Banner;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyBannerRequest extends FormRequest {

	public function authorize(): bool
	{
		abort_if(Gate::denies(PermissionEnum::BANNER_EDIT->value),Response::HTTP_FORBIDDEN,'403 Forbidden');
		return true;
	}

	public function rules(): array
	{
		return [
			'ids' => 'required|array',
			'ids.*' => 'exists:banners,id',
		];
	}
}
