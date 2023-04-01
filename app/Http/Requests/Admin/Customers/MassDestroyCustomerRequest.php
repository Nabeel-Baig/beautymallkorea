<?php

namespace App\Http\Requests\Admin\Customers;

use App\Enums\PermissionEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
		abort_if(Gate::denies(PermissionEnum::CUSTOMER_DELETE->value), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            'ids' => 'required|array',
			'ids.*' => 'exists:customers,id'
        ];
    }
}
