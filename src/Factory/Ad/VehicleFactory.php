<?php

namespace App\Factory\Ad;

use App\Entity\Vehicle;
use App\Factory\FactoryInterface;

class VehicleFactory extends AbstractAdFactory implements FactoryInterface
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
