<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Factories\ConfigFactory;
use AndrewSvirin\Interview\Factories\ServiceRegistryFactory;
use AndrewSvirin\Interview\Services\Container;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class BaseTestCase extends TestCase
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
        $config = ConfigFactory::produceFromFile();
        $registry = ServiceRegistryFactory::produceFromArray($config->get('services'));
        $this->container = new Container($config, $registry);
    }

    /**
     * @inheritDoc
     * Setup environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpContainer();
    }
}
