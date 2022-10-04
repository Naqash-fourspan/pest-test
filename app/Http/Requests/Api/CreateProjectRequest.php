<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\AbstractFormRequest;

class CreateProjectRequest extends AbstractFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:1000'],
            'owner_id' => ['required']
        ];
    }
}
