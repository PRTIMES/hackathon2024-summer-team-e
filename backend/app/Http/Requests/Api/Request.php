<?php

namespace App\Http\Requests\Api;

use App\Exceptions\HttpJsonResponseException;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class Request extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "code" => ["required", "regex:/\A[0-9]{6}\z/i"],
        ];
    }

    /**
     * @param Validator $validator
     * @throws HttpJsonResponseException
     */
    protected function failedValidation(Validator $validator): void
    {

        throw new HttpJsonResponseException(
            400,
            "validation",
            "Validation failed",
            $validator->errors()->toArray()
        );
    }
}
