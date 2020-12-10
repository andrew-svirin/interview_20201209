<?php

namespace AndrewSvirin\Interview\Adapters\Db;

/**
 * Interface DBAdapterInterface
 * Implements database usage interface.
 */
interface DbAdapterInterface
{

    /**
     * Output fetch formats.
     */
    const OUTPUT_FETCH_ALL_ASSOC = 2;

    /**
     * Establish connection to database.
     *
     * @param string $host
     * @param string $name
     * @param string $username
     * @param string $password
     * @param string $port
     *
     * @return mixed
     */
    public function connect(string $host, string $name, string $username, string $password, string $port);

    /**
     * Check that connection is established.
     *
     * @param mixed $connection
     *
     * @return bool
     */
    public function isConnection($connection): bool;

    /**
     * Close connection.
     *
     * @param mixed $connection
     *
     * @return bool
     */
    public function close($connection): bool;

    /**
     * Perform query.
     *
     * @param mixed $connection
     * @param string $query
     * @param array|null $params
     * @param int $outputFormat
     *
     * @return array|mixed
     */
    public function query(
        $connection,
        string $query,
        array $params = null,
        $outputFormat = DbAdapterInterface::OUTPUT_FETCH_ALL_ASSOC
    );
}
