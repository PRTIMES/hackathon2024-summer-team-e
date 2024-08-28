<?php

namespace App\Http\Requests\Api\Auth\SignIn;

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
            "email" => ["required", "email"]
        ];
    }
}
