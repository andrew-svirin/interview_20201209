<?php

namespace AndrewSvirin\Interview\Gateways\Db;

use AndrewSvirin\Interview\Services\DbClient;

/**
 * Common operations with database tables.
 */
abstract class TableGateway
{

    /**
     * DB client.
     *
     * @var DbClient
     */
    protected DBClient $dbClient;

    public function __construct(DBClient $dbClient)
    {
        $this->dbClient = $dbClient;
    }
}
