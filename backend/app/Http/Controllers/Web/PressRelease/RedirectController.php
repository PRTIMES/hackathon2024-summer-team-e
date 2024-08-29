<?php

namespace App\Http\Controllers\Web\PressRelease;

use App\Exceptions\HttpJsonResponseException;
use App\Http\Controllers\Controller;
use App\Models\Keyword;
use App\UseCases\ViewHistory\UpdateOrCreateAction as ViewHistoryUpdateOrCreateAction;
use App\UseCases\PressRelease\FindByIdsAction;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectController extends Controller
{
    /**
     * @param string $company_id
     * @param string $release_id
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function __invoke(string $company_id, string $release_id, Request $request): RedirectResponse
    {
        $user_id = Auth::id();
        if ($user_id === null || is_string($user_id)) // auth:sanctumで弾いているため最低限の例外
            throw new Exception("想定外エラー");

        $press_release = FindByIdsAction::run(company_id: (int) $company_id, release_id: (int) $release_id);

        if (!$press_release)
            abort(404);

        /* @var Keyword $keyword */
        foreach ($press_release->keywords()->get() as $keyword) {

            ViewHistoryUpdateOrCreateAction::run($user_id, $keyword->id);
        }

        $company_id_str = str_pad($company_id, 9, 0, STR_PAD_LEFT);
        $release_id_str = str_pad($release_id, 9, 0, STR_PAD_LEFT);
        return response()->redirectTo("https://prtimes.jp/main/html/rd/p/$release_id_str.$company_id_str.html");
    }
}
