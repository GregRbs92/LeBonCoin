<?php

namespace App\Factory\Ad;

use App\Factory\FactoryInterface;

abstract class AbstractAdFactory
{
    public static function getFactory(string $adCategory): FactoryInterface
    {
        switch ($adCategory) {
            case 'job': return JobFactory::instantiate();
            case 'vehicle': return VehicleFactory::instantiate();
            case 'property': return PropertyFactory::instantiate();

            default: return OtherFactory::instantiate();
        }
    }
}
