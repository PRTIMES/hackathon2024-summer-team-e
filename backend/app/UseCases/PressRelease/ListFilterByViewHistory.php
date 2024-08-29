<?php

namespace App\UseCases\PressRelease;

use App\Models\PressRelease;
use Illuminate\Database\Eloquent\Collection;

class ListFilterByViewHistory
{

    /**
     * @param int $user_id
     * @param "love"|"like"|"neutral" $mode
     * @param int $take
     * @return Collection<int, PressRelease>
     */
    public static function run(
        int $user_id,
        string $mode,
        int $take = 20
    ): Collection
    {
        return PressRelease::with("keywords.view_histories")->whereHas("keywords.view_histories", function ($query) use ($user_id, $mode) {
            $query->where("user_id", $user_id)
                  ->when($mode === "love", function ($query) {
                      $query->where("score", ">", 10);
                  })
                  ->when($mode === "like", function ($query) {
                      $query->where("score", ">", 2)
                            ->where("score", "<", 8);
                  });
        })->inRandomOrder()->take($take)->get();
    }
}