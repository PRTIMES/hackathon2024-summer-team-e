<?php

namespace App\UseCases\User;

use App\Models\User;
use App\Utils\Hash;

class CreateAction
{

    /**
     * @param string $name
     * @param string $email
     * @param string $job
     * @param int $age
     * @param string $prefecture
     * @return User
     */
    public static function run(
        string $name,
        string $email,
        string $job,
        int $age,
        string $prefecture
    ): User
    {
        $user = new User();

        $user->name = encrypt($name);
        $user->email = encrypt($email);
        $user->hash_email = Hash::generate($email);
        $user->job = $job;
        $user->age = $age;
        $user->prefecture = $prefecture;

        $user->save();
        return $user;
    }
}