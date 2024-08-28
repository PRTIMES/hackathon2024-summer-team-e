<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * @param mixed $data
     * @return JsonResponse
     */
    public function responseJson(mixed $data): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "data"   => $data
        ]);
    }
}
