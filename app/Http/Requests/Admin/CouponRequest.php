<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class CouponRequest extends FormRequest
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
            'time' => 'required',
            'condition' => 'required',
            'number' => 'required',
            'code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '* Tên mã giảm',
            'time' => '* Thời gian giảm',
            'condition' => '* Điều kiện giảm',
            'number' => '* Số giảm',
            'code' => '* Mã giảm',
            'start_date' => '* Ngày bắt đầu',
            'end_date' => '* Ngày kết thúc',
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
        ];
    }

    /**
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */
    protected function failed(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
