<?php

namespace App\UseCases\Keyword;

use App\Models\Keyword;

class CreateOrFirstAction
{
    public static function run(
        string $keyword,
        int $weight
    ): Keyword {
        // @todo barryvdh/laravel-ide-helperにより強制的に型付け
        /* @var Keyword */
        return Keyword::createOrFirst(
            compact("keyword", "weight"),
            compact("keyword", "weight")
        );
    }
}