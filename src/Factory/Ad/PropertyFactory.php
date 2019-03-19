<?php

namespace App\Factory\Ad;

use App\Entity\Property;

class PropertyFactory extends AbstractAdFactory
{
    private static $instance;

    public static function instantiate()
    {
        if (!isset(self::$instance)) {
            self::$instance = new PropertyFactory();
        }

        return self::$instance;
    }

    public static function createEntity()
    {
        $property = new Property();
        return $property;
    }
}
