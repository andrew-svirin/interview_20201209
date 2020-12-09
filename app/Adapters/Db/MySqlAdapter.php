<?php

namespace AndrewSvirin\Interview\Adapters\Db;

use InvalidArgumentException;
use mysqli;
use mysqli_result;
use RuntimeException;

class MySqlAdapter implements DbAdapterInterface
{

    /**
     * @inheritDoc
     * @return resource|mysqli
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
     * @param resource|mysqli $connection
     */
    public function close($connection): bool
    {
        return mysqli_close($connection); // @phpstan-ignore-line
    }

    /**
     * @inheritDoc
     * @param resource|mysqli $connection
     */
    public function query(
        $connection,
        string $query,
        array $params = null,
        $outputFormat = self::OUTPUT_FETCH_ALL_ASSOC
    ) {
        $queryResult = mysqli_query($connection, $query); // @phpstan-ignore-line
        if (!$queryResult) {
            throw new RuntimeException(mysqli_error($connection)); // @phpstan-ignore-line
        }

        $outputResult = $this->output($queryResult, $outputFormat);

        return $outputResult;
    }

    /**
     * Format query result.
     * @param resource|mysqli_result|bool $queryResult
     * @param int $format
     * @return array|mixed
     */
    private function output($queryResult, int $format)
    {
        switch ($format) {
            case self::OUTPUT_FETCH_ALL_ASSOC:
                $outputResult = mysqli_fetch_assoc($queryResult);  // @phpstan-ignore-line
                break;
            default:
                throw new InvalidArgumentException(sprintf('Fetch format `%d` not supported.', $format));
        }

        return $outputResult;
    }
}
