<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Tests\Components\ApiTrait;
use AndrewSvirin\Interview\Tests\Components\ContainerTrait;
use PHPUnit\Framework\TestCase;

abstract class BaseTestCase extends TestCase
{

    use ContainerTrait;
    use ApiTrait;

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
