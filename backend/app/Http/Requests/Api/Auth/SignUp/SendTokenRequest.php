<?php

namespace App\Http\Requests\Api\Auth\SignUp;

use Illuminate\Contracts\Validation\ValidationRule;
use App\Http\Requests\Api\Request;

class SendTokenRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "email"      => ["required", "email"],
            "name"       => ["required", "string", "max:100"],
            "age"        => ["required", "string", "regex:/\A[0-9]+\z/i"],
            "job"        => ["required", "string", "max:100"],
            "prefecture" => ["required", "string", "max:100"]
        ];
    }
}
