<?php

namespace App\UseCases\PressRelease;

use App\Models\PressRelease;

class CreateAction
{

    /**
     * @param int $company_id
     * @param int $release_id
     * @param string $title
     * @param string $summary
     * @param string $release_created_at
     * @return PressRelease
     */
    public static function run(
        int $company_id,
        int $release_id,
        string $title,
        string $summary,
        string $release_created_at
    ): PressRelease
    {
        $press_release = new PressRelease();

        $press_release->company_id = $company_id;
        $press_release->release_id = $release_id;
        $press_release->title = $title;
        $press_release->summary = $summary;
        $press_release->release_created_at = $release_created_at;

        $press_release->save();
        return $press_release;
    }
}