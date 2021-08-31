<?php

namespace App\Http\Requests\Sale\Password;

use Illuminate\Foundation\Http\FormRequest;

class ChangeRequest extends FormRequest
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
            'password' => 'required|min:8|max:15',
            'password_confirm' => 'required|same:password',
        ];
    }

    public function attributes()
    {
        return [
            'password' => '* Mật khẩu',
            'password_confirm' => '* Mật khẩu xác nhận',
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
            'same' => ':attribute không đúng với mất khẩu vừa nhập',
        ];
    }

    /**
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */
}
