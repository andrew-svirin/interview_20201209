<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;

class DBAdapterTest extends BaseTestCase
{

    /**
     * Create connection and check it.
     */
    public function testAdapter()
    {
        $this->assertInstanceOf(DbAdapterInterface::class, $this->container->get(DbAdapterInterface::class));
    }
}
