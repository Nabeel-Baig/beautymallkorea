<?php

namespace App\Http\Requests\settings;

use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => 'required',
            'title' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'link' => 'sometimes|required',
            'logo' => 'sometimes|required|image|mimes:jpeg,jpg,png',
            'favico' => 'sometimes|required|image|mimes:jpeg,jpg,png'
        ];
    }
}
