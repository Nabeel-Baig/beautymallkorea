<?php

namespace App\Http\Requests\Admin\Coupon;

use App\Enums\CouponType;
use App\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Enum;
use Symfony\Component\HttpFoundation\Response;

class UpdateCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
		abort_if(Gate::denies(PermissionEnum::COUPON_EDIT->value), Response::HTTP_FORBIDDEN, '403 Forbidden');
		return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
		return [
			'name' => 'required|string',
			'code' => 'required|string',
			'type' => ['required', new Enum(CouponType::class)],
			'discount' => 'required|numeric',
			'date_start' => 'required|date',
			'date_end' => 'required|date',

//			Categories
			'categories' => ['nullable', 'array'],
			'categories.*' => ['required', 'numeric'],

//			Products
			'products' => ['nullable', 'array'],
			'products.*' => ['required', 'numeric'],
		];
    }
}
