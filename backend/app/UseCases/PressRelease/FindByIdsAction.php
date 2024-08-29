<?php

namespace App\UseCases\PressRelease;

use App\Models\PressRelease;
use App\Models\User;

class FindByIdsAction
{

    /**
     * @param int $company_id
     * @param int $release_id
     * @return User|null
     */
    public static function run(
        int $company_id,
        int $release_id
    ): PressRelease|null
    {
        return PressRelease::where("company_id", $company_id)
                           ->where("release_id", $release_id)
                           ->with(["company"])
                           ->first();
    }
}