<?php

namespace App\UseCases\User;

use App\Models\User;

class FindByIdAction
{

    /**
     * @param int $id
     * @return User|null
     */
    public static function run(int $id): User|null
    {
        return User::where("id", $id)->first();
    }
}