<?php

namespace App\Factory;

interface FactoryInterface
{
    /**
     * Returns a singleton instance of the factory
     *
     * @return self
     */
    public static function instantiate();

    /**
     * Instantiate a new entity corresponding to the factory
     */
    public static function createEntity();
}
