<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Services\Container;
use AndrewSvirin\Interview\Services\ServiceRegistry;
use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

abstract class BaseTestCase extends TestCase
{
    /**
     * Application container.
     */
    protected ContainerInterface $container;

    /**
     * Setup environment.
     */
    private function setUpEnvironment(): void
    {
        // Create in unsafe mode to access by function `getenv`.
        $dotenv = Dotenv::createUnsafeImmutable(BASE_DIR);
        $dotenv->load();
        $dotenv->required(['DB_HOST', 'DB_NAME', 'DB_USERNAME', 'DB_PASSWORD']);
    }

    /**
     * Setup container.
     */
    private function setUpContainer(): void
    {
        $registry = new ServiceRegistry();
        $container = new Container($registry);
        $this->container = $container;
    }

    /**
     * @inheritDoc
     * Setup environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->setUpEnvironment();
        $this->setUpContainer();
    }
}
