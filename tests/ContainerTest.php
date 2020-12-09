<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Services\ServiceRegistry;
use Psr\Container\ContainerInterface;

class ContainerTest extends BaseTestCase
{

    /**
     * Set service to container and get service from container.
     */
    public function testGetRegistry()
    {
        $this->assertInstanceOf(ContainerInterface::class, $this->container);
        $this->assertInstanceOf(ServiceRegistry::class, $this->container->get('registry'));
    }
}
