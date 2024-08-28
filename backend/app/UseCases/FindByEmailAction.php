<?php

namespace App\UseCases;

use App\Models\User;
use App\Utils\Hash;

class FindByEmailAction
{

    /**
     * @param string $email
     * @return User|null
     */
    public static function run(
        string $email
    ): User|null
    {
        return User::where("hash_email", Hash::generate($email))
                   ->first();
    }
}