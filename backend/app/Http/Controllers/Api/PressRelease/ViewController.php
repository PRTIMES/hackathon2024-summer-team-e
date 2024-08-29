<?php

namespace App\Http\Controllers\Api\PressRelease;

use App\Exceptions\HttpJsonResponseException;
use App\Http\Controllers\Controller;
use App\Models\Keyword;
use App\UseCases\ViewHistory\UpdateOrCreateAction as ViewHistoryUpdateOrCreateAction;
use App\UseCases\PressRelease\FindByIdsAction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ViewController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $user_id = Auth::id();
        if ($user_id === null || is_string($user_id)) // auth:sanctumで弾いているため最低限の例外
            throw new Exception("想定外エラー");

        $company_id = $request->get("company_id");
        $release_id = $request->get("release_id");

        $press_release = FindByIdsAction::run(company_id: $company_id, release_id: $release_id);

        if (!$press_release)
            throw new HttpJsonResponseException(
                400,
                "notfound",
                "PressRelease Not Found",
                compact("company_id", "release_id")
            );

        /* @var Keyword $keyword */
        foreach ($press_release->keywords() as $keyword) {

            ViewHistoryUpdateOrCreateAction::run($user_id, $keyword->id);
        }

        return response()->json(["result" => "ok"]);
    }
}
