<?php

namespace App\Http\Requests\Api\Auth\SignUp;

use App\Http\Requests\Api\Request;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifyRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "token" => ["required", "regex:/\A[0-9]{6}\z/i"]
        ];
    }
}
