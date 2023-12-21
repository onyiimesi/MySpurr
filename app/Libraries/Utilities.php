<?php

namespace App\Libraries;

class Utilities {

    public static function generateNuban($id)
    {
        $nuban = strrev(substr((int)($id / 5 * 10) . rand(pow(10, 10), pow(10, 11) - 1), 0, 10));
        return $nuban;
    }

}