<?php

namespace App\Http\Controllers\Api\PressRelease;

use App\Http\Controllers\Controller;
use App\Models\PressRelease;
use Exception;
use App\UseCases\PressRelease\ListFilterByViewHistory as PressReleaseListFilterByViewHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendController extends Controller
{
    const PRESS_RELEASE_COUNT = 20;

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

        $love    = PressReleaseListFilterByViewHistory::run($user_id, self::PRESS_RELEASE_COUNT * 0.7, "love");
        $like    = PressReleaseListFilterByViewHistory::run($user_id, self::PRESS_RELEASE_COUNT * 0.2, "like");

        $neutral = PressReleaseListFilterByViewHistory::run(
            $user_id,
            self::PRESS_RELEASE_COUNT - $love->count() - $like->count(),
            "neutral"
        );

        $recommend = $neutral->merge($love)->merge($like)->shuffle();

        return response()->json(
            $recommend->map(function ($press_release) {
                /* @var PressRelease $press_release */

                return [
                    "id"      => $press_release->id,
                    "title"   => $press_release->title,
                    "summary" => $press_release->summary
                ];
            })
                      ->toArray()
        );
    }
}
