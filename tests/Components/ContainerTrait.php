<?php

namespace AndrewSvirin\Interview\Tests\Components;

use AndrewSvirin\Interview\Factories\ConfigFactory;
use AndrewSvirin\Interview\Factories\ServiceRegistryFactory;
use AndrewSvirin\Interview\Services\Container;
use Psr\Container\ContainerInterface;

/**
 * Include container functionality to tests.
 */
trait ContainerTrait
{
    /**
     * Application container.
     */
    protected ContainerInterface $container;

    /**
     * Setup container.
     */
    private function setUpContainer(): void
    {
        $config = ConfigFactory::createFromFile();
        $registry = ServiceRegistryFactory::createFromArray($config->get('services'));
        $this->container = new Container($config, $registry);
    }
}
