<?php

namespace App\Factory\Ad;

abstract class AbstractAdFactory
{
    public static function getFactory(string $adCategory): AbstractAdFactory
    {
        switch ($adCategory) {
            case 'job': return JobFactory::instantiate();
            case 'vehicle': return VehicleFactory::instantiate();
            case 'property': return PropertyFactory::instantiate();

            default: return OtherFactory::instantiate();
        }
    }
}
