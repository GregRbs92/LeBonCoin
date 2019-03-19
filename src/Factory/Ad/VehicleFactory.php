<?php

namespace App\Factory\Ad;

use App\Entity\Vehicle;

class VehicleFactory extends AbstractAdFactory
{
    private static $instance;

    public static function instantiate()
    {
        if (!isset(self::$instance)) {
            self::$instance = new VehicleFactory();
        }

        return self::$instance;
    }

    public static function createEntity()
    {
        $vehicle = new Vehicle();
        return $vehicle;
    }
}
