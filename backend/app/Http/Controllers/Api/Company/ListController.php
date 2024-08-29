<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\UseCases\Company\ListFilterByIndustryIds;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $industry_ids_raw = $request->query("industry_ids");
        if ($industry_ids_raw === null)
            return response()->json();

        $industry_ids = is_array($industry_ids_raw)
            ? array_map(fn ($industry_id) => (int) $industry_id, $industry_ids_raw)
            : [(int) $industry_ids_raw];

        $companies = ListFilterByIndustryIds::run($industry_ids);

        return response()->json(
            $companies->map(function ($company) {
                /* @var Company $company */
                return [
                    "id" => $company->id,
                    "name" => $company->name
                ];
            })->toArray()
        );
    }
}
