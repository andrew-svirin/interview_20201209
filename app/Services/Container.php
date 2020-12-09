<?php

namespace AndrewSvirin\Interview\Services;

use Psr\Container\ContainerInterface;

/**
 * Contains IoC services dependencies.
 * Realizing pattern ServiceLocator.
 */
class Container implements ContainerInterface
{

    /**
     * Instantiated classes.
     * @var array
     */
    private array $instantiated = [];

    public function __construct(ServiceRegistry $registry)
    {
        $this->instantiated[ServiceRegistry::class] = $registry;
    }

    /**
     * @inheritDoc
     *
     * Find service in registry.
     * If service will not be found in container, then create new one.
     *
     * @param string $id The class name of service.
     */
    public function get($id)
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     *
     * Find service in registry.
     *
     * @param string $id The class name of service.
     */
    public function has($id)
    {
        // TODO: Implement has() method.
    }
}
