<?php

namespace App\Utils;

class CommonService
{
    public static function isAllDefined(...$vars)
    {
        foreach($vars as $var) {
            if (!isset($var) || empty($var)) {
                return false;
            }
        }

        return true;
    }
}
