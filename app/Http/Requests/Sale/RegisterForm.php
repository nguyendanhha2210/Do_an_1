<?php

namespace App\Http\Requests\Sale;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterForm extends FormRequest
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
            'email' => Rule::unique('users')->ignore($this->id),
        ];
    }

    public function attributes()
    {
        return [
            'email' => '* Email',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute là bắt buộc',
            'numeric' => ':attribute phải là số',
            'image' => ':attribute không phải là hình ảnh',
            'mimes' => ':attribute phải có định dạng jpeg,png,jpg,gif,svg',
            'min' => ':attribute ít nhất phải có :min ký tự',
            'max' => ':attribute không được vượt quá :max ký tự',
            'email' => ':attribute không đúng định dạng email',
            'regex' => ':attribute không đúng định dạng số điện thoại',
            'unique' => ':attribute đã tồn tại',
        ];
    }

    /**
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */
    protected function failed(Validator $validator)
    {
        throw new HttpResponseException(response()->json( $validator->errors(), 422));
    }
}
