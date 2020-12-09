<?php

namespace AndrewSvirin\Interview\Services;

use Psr\Container\ContainerInterface;

/**
 * Contains IoC services dependencies.
 */
class Container implements ContainerInterface
{

    /**
     * @inheritDoc
     *
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
     * @param string $id The class name of service.
     */
    public function has($id)
    {
        // TODO: Implement has() method.
    }
}
