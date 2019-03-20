<?php

namespace App\Factory\Ad;

use App\Entity\Job;
use App\Factory\FactoryInterface;

class JobFactory extends AbstractAdFactory implements FactoryInterface
{
    private static $instance;

    public static function instantiate()
    {
        if (!isset(self::$instance)) {
            self::$instance = new JobFactory();
        }

        return self::$instance;
    }

    public static function createEntity()
    {
        $job = new Job();
        return $job;
    }
}
