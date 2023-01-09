<?php

namespace App\Http\Requests\users;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id'
        ];
    }
}
