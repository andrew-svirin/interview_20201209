<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;
use AndrewSvirin\Interview\Services\Config;

/**
 * Tests for @see DbAdapterInterface
 *
 * @group db-adapter
 */
class DbAdapterTest extends BaseTestCase
{

    /**
     * CHeck db adapter is instantiated.
     */
    public function testAdapter()
    {
        $this->assertInstanceOf(DbAdapterInterface::class, $this->container->get(DbAdapterInterface::class));
    }

    /**
     * Create connection.
     */
    public function testConnect()
    {
        /* @var $dbAdapter DbAdapterInterface */
        $dbAdapter = $this->container->get(DbAdapterInterface::class);

        /* @var $config Config */
        $config = $this->container->get(Config::class);

        $this->assertNotEmpty($dbAdapter->connect(
            $config->get('database.host'),
            $config->get('database.name'),
            $config->get('database.username'),
            $config->get('database.password'),
            $config->get('database.port')
        ));
    }

    /**
     * Connect and close.
     */
    public function testClose()
    {
        /* @var $dbAdapter DbAdapterInterface */
        $dbAdapter = $this->container->get(DbAdapterInterface::class);

        /* @var $config Config */
        $config = $this->container->get(Config::class);

        $connection = $dbAdapter->connect(
            $config->get('database.host'),
            $config->get('database.name'),
            $config->get('database.username'),
            $config->get('database.password'),
            $config->get('database.port')
        );

        $this->assertTrue($dbAdapter->close($connection));
    }

    /**
     * Connect make query and close.
     * @group db-adapter-query
     */
    public function testQuery()
    {
        /* @var $dbAdapter DbAdapterInterface */
        $dbAdapter = $this->container->get(DbAdapterInterface::class);

        /* @var $config Config */
        $config = $this->container->get(Config::class);

        $connection = $dbAdapter->connect(
            $config->get('database.host'),
            $config->get('database.name'),
            $config->get('database.username'),
            $config->get('database.password'),
            $config->get('database.port')
        );

        $result = $dbAdapter->query($connection, 'SELECT ? as RES;', [100]);

        $dbAdapter->close($connection);

        $this->assertEquals([['RES' => '100']], $result);
    }
}
