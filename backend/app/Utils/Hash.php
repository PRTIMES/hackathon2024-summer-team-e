<?php

namespace App\Utils;

class Hash
{

    public static function generate($value): string
    {
        return hash("sha512", $value);
    }
}