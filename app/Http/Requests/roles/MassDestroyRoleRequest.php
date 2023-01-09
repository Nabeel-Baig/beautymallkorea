<?php

namespace App\Http\Requests\roles;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Role;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('role_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
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
            'ids.*' => 'exists:roles,id',
        ];
    }
}
