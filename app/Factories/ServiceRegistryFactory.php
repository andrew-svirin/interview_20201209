<?php

namespace AndrewSvirin\Interview\Factories;

use AndrewSvirin\Interview\Services\ServiceRegistry;

/**
 * Produce service registry.
 */
class ServiceRegistryFactory
{

    /**
     * Produce service registry from array.
     *
     * @param array $services
     *
     * @return ServiceRegistry
     */
    public static function produceFromArray(array $services): ServiceRegistry
    {
        $registry = new ServiceRegistry();

        // Go over configuration services.
        foreach ($services as $alias => $className) {
            $registry->set($className, $className);

            // Means that alias was specified.
            if (!is_numeric($alias)) {
                $registry->set($alias, $className);
            }
        }

        return $registry;
    }
}
