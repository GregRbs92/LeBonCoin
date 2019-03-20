<?php

namespace App\Factory\Ad;

use App\Entity\Other;
use App\Factory\FactoryInterface;

class OtherFactory extends AbstractAdFactory implements FactoryInterface
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
