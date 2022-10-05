<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\AbstractFormRequest;

class LoginRequest extends AbstractFormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required'],
            'password' => ['required']
        ];
    }
}
