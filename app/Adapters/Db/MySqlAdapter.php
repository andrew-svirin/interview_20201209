<?php

namespace AndrewSvirin\Interview\Adapters\Db;

use AndrewSvirin\Interview\Exceptions\DbQueryInvalidException;
use InvalidArgumentException;
use mysqli;
use mysqli_result;
use RuntimeException;

class MySqlAdapter implements DbAdapterInterface
{

    /**
     * @inheritDoc
     */
    public function connect(string $host, string $name, string $username, string $password, string $port)
    {
        $connection = mysqli_connect($host, $username, $password, $name, (int)$port);

        if (!$connection) {
            throw new RuntimeException(mysqli_connect_error());
        }

        return $connection;
    }

    /**
     * @inheritDoc
     */
    public function isConnection($connection): bool
    {
        return $connection instanceof mysqli;
    }

    /**
     * @inheritDoc
     */
    public function close($connection): bool
    {
        return mysqli_close($connection);
    }

    /**
     * @inheritDoc
     * @throws DbQueryInvalidException
     */
    public function query(
        $connection,
        string $query,
        array $params = null,
        $outputFormat = self::OUTPUT_FETCH_ALL_ASSOC
    ) {
        // Create query statement.
        if (!($stmt = mysqli_prepare($connection, $query))) {
            throw new DbQueryInvalidException(mysqli_error($connection));
        }

        // TODO: recognize params types correctly.
        // Bind parameters
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            mysqli_stmt_bind_param($stmt, $types, ...$params);
        }

        // Execute query.
        mysqli_stmt_execute($stmt);

        // Get query result.
        $queryResult = mysqli_stmt_get_result($stmt);

        // Close statement.
        mysqli_stmt_close($stmt);

        // Check that query result is empty.
        if (!$queryResult) {
            return null;
        }

        $outputResult = $this->output($queryResult, $outputFormat);

        return $outputResult;
    }

    /**
     * Format query result.
     *
     * @param mysqli_result|bool $queryResult
     * @param int $format
     *
     * @return array|mixed|null
     */
    private function output($queryResult, int $format)
    {
        switch ($format) {
            case self::OUTPUT_FETCH_ALL_ASSOC:
                $outputResult = mysqli_fetch_all($queryResult, MYSQLI_ASSOC); // @phpstan-ignore-line
                break;
            default:
                throw new InvalidArgumentException(sprintf('Fetch format `%d` not supported.', $format));
        }

        return $outputResult;
    }
}
