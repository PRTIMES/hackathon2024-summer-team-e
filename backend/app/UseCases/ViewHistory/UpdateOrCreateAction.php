<?php

namespace App\UseCases\ViewHistory;

use App\Models\ViewHistory;
use Illuminate\Support\Facades\DB;

class UpdateOrCreateAction
{
    /**
     * @param int $user_id
     * @param int $keyword_id
     * @return ViewHistory
     */
    public static function run(
        int $user_id,
        int $keyword_id
    ): ViewHistory {
        // @todo barryvdh/laravel-ide-helperにより強制的に型付け
        /* @var ViewHistory */
        return ViewHistory::updateOrCreate(
            ["user_id" => $user_id, "keyword_id" => $keyword_id],
            ["score" => DB::raw("score++")]
        );
    }
}