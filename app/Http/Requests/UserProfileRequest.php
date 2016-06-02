<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserProfileRequest extends Request
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
            'user_id' => 'required',
            'cetagory_id' => 'required',
            'fullname' => 'required',
            'born' => 'required',
            'picture' => 'required',
            'summary' => 'required',
            'profile' => 'required',
            'website' => 'required',
            'type' => 'required',
        ];
    }
}
