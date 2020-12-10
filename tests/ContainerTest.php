<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Services\Config;
use AndrewSvirin\Interview\Services\ServiceRegistry;
use Psr\Container\ContainerInterface;

class ContainerTest extends BaseTestCase
{

    /**
     * Is container exists.
     */
    public function testIsContainer()
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
    }

    /**
     * Get service registry from container.
     */
    public function testGetRegistry()
    {
        $this->assertInstanceOf(ServiceRegistry::class, $this->container->get(ServiceRegistry::class));
    }

    /**
     * Is config in container.
     */
    public function testHasConfig()
    {
        $this->assertTrue($this->container->has(Config::class));
    }
}
