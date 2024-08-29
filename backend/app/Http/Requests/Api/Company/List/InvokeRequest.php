<?php

namespace App\Http\Requests\Api\Company\List;

use App\Http\Requests\Api\Request;
use Illuminate\Contracts\Validation\ValidationRule;

class InvokeRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "industry_ids"   => ["required", "array"],
            "industry_ids.*" => ["integer", "min:1", "max:16"],
        ];
    }
}
