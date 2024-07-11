<?php

namespace App\Http\Requests\UserRequests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            "email" => [
                "required",
                "email",
            ],
            "password" => [
                "required",
            ],
        ];

        return $rules;
    }

    public function failedValidation(Validator $validator)
    {
        if ($this->isMethod('get')) {
            throw new HttpResponseException(
                response()->json(
                    ['errors' => [
                        'auth' => [
                            'Token missing or expired'
                        ],
                    ]],
                    401
                )
            );
        } else if ($this->isMethod('post')) {
            $errors = $validator->errors();

            throw new HttpResponseException(
                response()->json(['errors' => $errors], 422)
            );
        }
    }
}
