<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class WareHouseRequest extends FormRequest
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
            'name'=> 'required|min:2', 
            'images'=> 'required|image|mimes:jpeg,png,jpg,gif,svg', 
            'import_price'=> 'required|regex:/^\d+(\.\d{1,2})?$/', 
            'import_quantity'=> 'required|numeric', 
        ];
    }
    
    public function attributes()
    {
        return [
            'name' => '* Tên',
            'images'=> '* Hình ảnh', 
            'import_price'=> '* Giá nhập', 
            'import_quantity'=> '* Số lượng nhập', 
            'inventory'=> '* Hàng tồn kho', 
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
            'regex' => ':attribute không đúng định dạng',
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
