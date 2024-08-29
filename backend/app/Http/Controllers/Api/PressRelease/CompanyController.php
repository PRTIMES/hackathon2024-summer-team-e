<?php

namespace App\Http\Controllers\Api\PressRelease;

use App\Http\Controllers\Controller;
use App\Models\PressRelease;
use App\UseCases\PressRelease\ListFilterByCompanyId as PressReleaseListFilterByCompanyId;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    const PRESS_RELEASE_COUNT = 10;

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $company_ids_raw = $request->query("company_ids");
        if ($company_ids_raw === null)
            return response()->json();

        $company_ids = is_array($company_ids_raw)
            ? array_map(fn ($company_id) => (int) $company_id, $company_ids_raw)
            : [(int) $company_ids_raw];

        $releases = PressReleaseListFilterByCompanyId::run($company_ids, self::PRESS_RELEASE_COUNT);

        return response()->json(
            $releases->map(function ($press_release) {
                /* @var PressRelease $press_release */

                return [
                    "title"   => $press_release->title,
                    "summary" => $press_release->summary,
                    "company_name" => $press_release->company->name,
                    "url"     => route(
                        "press-release.redirect",
                        [
                            "company_id" => $press_release->company_id,
                            "release_id" => $press_release->release_id
                        ]
                    )
                ];
            })
                     ->toArray()
        );
    }
}
