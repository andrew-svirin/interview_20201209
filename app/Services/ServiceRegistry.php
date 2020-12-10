<?php

namespace AndrewSvirin\Interview\Services;

use AndrewSvirin\Interview\Exceptions\ServiceNotFoundException;

/**
 * Contains aliases for instantiation of classes.
 */
class ServiceRegistry
{

    /**
     * Registered services.
     */
    private array $services = [];

    /**
     * Get service by alias or by class name.
     *
     * @param string $id Service id in registry.
     *
     * @return string Service class name.
     * @throws ServiceNotFoundException
     */
    public function get(string $id)
    {
        if (!isset($this->services[$id])) {
            throw new ServiceNotFoundException(sprintf('Service `%s` not found.', $id));
        }

        return $this->services[$id];
    }

    /**
     * Set service to registry.
     *
     * @param string $id Service id in registry.
     * @param string $className Class name to be instantiated.
     */
    public function set(string $id, string $className): void
    {
        $this->services[$id] = $className;
    }
}
