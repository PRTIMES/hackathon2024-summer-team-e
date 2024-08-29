<?php

namespace App\UseCases\Company;

use App\Models\Company;
use Illuminate\Database\Eloquent\Collection;

class ListFilterByIndustryIds
{
    /**
     * @param int[] $industry_ids
     * @param int $count
     * @return Collection<int, Company>
     */
    public static function run(
        array $industry_ids,
        int $count = 20
    ): Collection {
        return Company::whereIn("industry_id", $industry_ids)
                      ->inRandomOrder()
                      ->take($count)
                      ->get();
    }
}