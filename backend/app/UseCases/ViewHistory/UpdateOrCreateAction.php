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
        // @todo barryvdh/laravel-ide-helperのバグにより強制的に型付け
        /* @var ViewHistory $view_history */
        $view_history = ViewHistory::createOrFirst(["user_id" => $user_id, "keyword_id" => $keyword_id], ["score" => 1]);

        // すでに作成済みの場合
        if (!$view_history->wasRecentlyCreated)
            $view_history->fill(["score" => DB::raw("score + 1")])->save();

        // @todo DB::rawをfillしてるから返り値の方が違うかも（多分scoreが取れない
        return $view_history;
    }
}