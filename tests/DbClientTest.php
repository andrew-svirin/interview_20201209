<?php

namespace AndrewSvirin\Interview\Tests;

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;
use AndrewSvirin\Interview\Services\DbClient;

/**
 * Tests for @see DbAdapterInterface
 *
 * @group db-client
 */
class DbClientTest extends BaseTestCase
{

    /**
     * DB client is instantiated.
     */
    public function testClient()
    {
        $this->assertInstanceOf(DbClient::class, $this->container->get(DbClient::class));
    }

    /**
     * Create connection.
     */
    public function testConnect()
    {
        /* @var $dbClient DbClient */
        $dbClient = $this->container->get(DbClient::class);

        $dbClient->connect();

        $this->assertTrue($dbClient->isConnected());
    }

    /**
     * Connect and close.
     */
    public function testClose()
    {
        /* @var $dbClient DbClient */
        $dbClient = $this->container->get(DbClient::class);

        $dbClient->connect();

        $this->assertTrue($dbClient->close());
    }

    /**
     * Connect make query and close.
     * @group db-client-query
     */
    public function testQuery()
    {
        /* @var $dbClient DbClient */
        $dbClient = $this->container->get(DbClient::class);

        $dbClient->connect();

        $result = $dbClient->query('SELECT ? as RES;', [100]);

        $dbClient->close();

        $this->assertEquals([['RES' => '100']], $result);
    }
}
