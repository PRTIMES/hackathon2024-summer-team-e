<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Company\List\InvokeRequest;
use App\Models\Company;
use App\UseCases\Company\ListFilterByIndustryIds;
use Illuminate\Http\JsonResponse;

class ListController extends Controller
{
    /**
     * @param InvokeRequest $request
     * @return JsonResponse
     */
    public function __invoke(InvokeRequest $request): JsonResponse
    {
        /* @var int[] $industry_ids */
        $industry_ids = $request->validated()['industry_ids'];

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
