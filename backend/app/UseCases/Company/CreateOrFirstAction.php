<?php

namespace App\UseCases\Company;

use App\Models\Company;

class CreateOrFirstAction
{
    /**
     * @param int $company_id
     * @param string $name
     * @param int $industry_id
     * @param int $popularity
     * @return Company
     */
    public static function run(
        int $company_id,
        string $name,
        int $industry_id,
        int $popularity = 0
    ): Company {
        // @todo barryvdh/laravel-ide-helperにより強制的に型付け
        /* @var Company */
        return Company::createOrFirst(
            compact("company_id"), // 検索用データ
            compact("company_id", "name", "industry_id", "popularity") // 作成用データ
        );
    }
}