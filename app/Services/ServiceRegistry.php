<?php

namespace AndrewSvirin\Interview\Services;

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
     * @param string $name Service name in registry.
     * @return string
     */
    public function get(string $name): string
    {
        // TODO: Implement get() method.
    }

    /**
     * Set service to registry.
     *
     * @param string $name Service name in registry.
     * @param string $className Class name to be instantiated.
     */
    public function set(string $name, string $className): void
    {
        // TODO: Implement set() method.
    }
}
