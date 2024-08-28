<?php

namespace App\Utils;

use Random\RandomException;

class OneTimeToken
{
    /**
     * @return string
     * @throws RandomException
     */
    public static function generate(): string
    {

        return str_pad(
            strval(random_int(0, 999999)),
            6,
            "0",
            STR_PAD_LEFT
        );
    }
}