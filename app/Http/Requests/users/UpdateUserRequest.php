<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'roles.*' => ['integer'],
            'roles' => ['required','array'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'dob' => ['sometimes','required'],
            'address' => ['sometimes','required'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'avatar' => ['sometimes','required', 'image' ,'mimes:jpg,jpeg,png'],
        ];
    }
}
