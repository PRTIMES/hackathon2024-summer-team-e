<?php

namespace App\UseCases\Keyword;

use App\Models\Keyword;

class CreateOrFirstAction
{
    /**
     * @param string $keyword
     * @return Keyword
     */
    public static function run(
        string $keyword
    ): Keyword {
        // @todo barryvdh/laravel-ide-helperにより強制的に型付け
        /* @var Keyword */
        return Keyword::createOrFirst(
            ["keyword" => $keyword],
            ["keyword" => $keyword]
        );
    }
}