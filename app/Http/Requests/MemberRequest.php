<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class MemberRequest extends Request
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
            'member_name' => 'required',
            'member_born' => 'required',
            'member_gender' => 'required',
            'member_summary' => 'required',
            'member_profile' => 'required',
            'member_website' => 'required',
            'member_type' => 'required',
            'member_category' => 'required'
        ];
    }
}
