<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class AbstractFormRequest extends FormRequest
{

    public function newResponse($errors)
    {
        return new JsonResponse([ 'message'=> $errors ], Response::HTTP_BAD_REQUEST);
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->newResponse(
            $validator->errors()->first()
        ));
    }
}
