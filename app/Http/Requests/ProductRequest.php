<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProductRequest extends Request
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
            'category_id' => 'required',
            /*'product_code' => 'required',
            'product_logo' => 'required',
            'product_quote' => 'required',
            'product_desc' => 'required|min:3',
            'product_data' => 'required',
            'product_website' => 'required',
            'product_release' => 'required',
            'product_view' => 'required',
            'product_embed' => 'required'*/
        ];
    }
}
