<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class ManageBannerRequest extends FormRequest {

	final public function authorize(): bool
	{
		abort_if(Gate::denies('banner_create'), Response::HTTP_FORBIDDEN,'403 Forbidden');
		return true;
	}

	final public function rules(): array
	{
		return [
			"banner_type" => "required|string",
			"title" => "nullable|sometimes|required|string",
			"link" => "nullable|sometimes|required|url",
			"image" => "required|image",
			"sort_order" => "required|integer",
		];
	}
}
