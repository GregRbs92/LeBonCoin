<?php

namespace App\Factory\Ad;

use App\Entity\Job;

class JobFactory extends AbstractAdFactory
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
