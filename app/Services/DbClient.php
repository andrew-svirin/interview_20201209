<?php

namespace AndrewSvirin\Interview\Services;

use AndrewSvirin\Interview\Adapters\Db\DbAdapterInterface;

/**
 * Implements database access.
 */
class DbClient
{

    /**
     * Adapter for database.
     *
     * @var DBAdapterInterface
     */
    private DBAdapterInterface $dbAdapter;

    /**
     * App configurations.
     * @var Config
     */
    private Config $config;

    /**
     * Connection to database.
     * @var resource
     */
    private $connection;

    /**
     * DbClient constructor.
     * Create connection on construct.
     *
     * @param DbAdapterInterface $dbAdapter
     * @param Config $config
     */
    public function __construct(DBAdapterInterface $dbAdapter, Config $config)
    {
        $this->dbAdapter = $dbAdapter;
        $this->config = $config;
        $this->connect();
    }

    /**
     * Close db connection on destruction.
     */
    public function __destruct()
    {
        $this->close();
    }

    /**
     * Open connection to database.
     */
    public function connect(): void
    {
        $this->connection = $this->dbAdapter->connect(
            $this->config->get('database.host'),
            $this->config->get('database.name'),
            $this->config->get('database.username'),
            $this->config->get('database.password'),
            $this->config->get('database.port')
        );
    }

    /**
     * Close connection to database.
     */
    public function close(): bool
    {
        return $this->dbAdapter->close($this->connection);
    }

    /**
     * Check that connection exists.
     * @return bool
     */
    public function isConnected(): bool
    {
        return $this->dbAdapter->isConnection($this->connection);
    }

    /**
     * Perform query.
     *
     * @param string $query
     * @param array|null $params
     * @param int $outputFormat
     *
     * @return array|mixed|null
     */
    public function query(
        string $query,
        array $params = null,
        $outputFormat = DBAdapterInterface::OUTPUT_FETCH_ALL_ASSOC
    ) {
        return $this->dbAdapter->query($this->connection, $query, $params ?? [], $outputFormat);
    }
}
