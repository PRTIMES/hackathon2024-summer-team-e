<?php

namespace App\UseCases\PressRelease;

use App\Models\PressRelease;
use Illuminate\Database\Eloquent\Collection;

class ListFilterByCompanyId
{

    /**
     * @param array $company_ids
     * @param int $take
     * @return Collection<int, PressRelease>
     */
    public static function run(
        array $company_ids,
        int $take = 10
    ): Collection
    {
        return PressRelease::with("company")
                           ->whereIn("company_id", $company_ids)
                           ->inRandomOrder()->take($take)->get();
    }
}