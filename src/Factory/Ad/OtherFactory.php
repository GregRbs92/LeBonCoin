<?php

namespace App\Factory\Ad;

use App\Entity\Other;

class OtherFactory extends AbstractAdFactory
{
    private static $instance;

    public static function instantiate()
    {
        if (!isset(self::$instance)) {
            self::$instance = new OtherFactory();
        }

        return self::$instance;
    }

    public static function createEntity()
    {
        $other = new Other();
        return $other;
    }
}
