<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'uuid' => ['required'],
            'email' => ['required', 'unique:users,email', 'email'],
            'password' => ['required', 'min:3','confirmed'],
            'name' => ['required'],
        ];
    }
}
