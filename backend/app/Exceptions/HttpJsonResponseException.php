<?php

namespace App\Exceptions;

use Illuminate\Http\Exceptions\HttpResponseException;

class HttpJsonResponseException extends HttpResponseException
{
    public function __construct(
        int $code,
        string $type,
        string $message,
        array $data = []
    )
    {
        $status = "error";

        parent::__construct(
            response()->json(
                compact("status", "type", "message", "data"),
                $code
            )
        );
    }
}