<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAuthRequest extends FormRequest
{
	final public function authorize(): bool
	{
		return true;
	}
	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json($validator->errors(), 422));
	}

	final public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
			'phone' => ['required', 'string', 'max:255'],
			'password' => ['required', 'string', 'min:6', 'confirmed']
		];
	}
}
