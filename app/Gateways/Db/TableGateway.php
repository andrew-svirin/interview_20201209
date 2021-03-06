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

    /**
     * Get auto incrementing value.
     *
     * @param array $result
     *
     * @return int
     */
    protected function getAutoIncrementValue(array $result): int
    {
        $id = (int)$result[0]['AUTO_INCREMENT'];

        return $id;
    }

    /**
     * Apply query condition fields.
     *
     * @param array|null $conditionFields
     *
     * @return string
     */
    protected function prepareQueryConditionFieldsString(array $conditionFields = null): ?string
    {
        // Case for none conditions.
        if (empty($conditionFields)) {
            return null;
        }

        $conditionFieldParts = [];

        // Prepare field conditions string.
        foreach ($conditionFields as $field) {
            $conditionFieldParts[] = '`' . $field . '` = ?';
        }
        $conditionFieldsString = implode(' AND ', $conditionFieldParts);

        return $conditionFieldsString;
    }

    /**
     * Put where conditions fields string in query.
     *
     * @param string $query
     * @param string|null $conditionFieldsString
     *
     * @return string|null
     */
    protected function putQueryWhere(string $query, string $conditionFieldsString = null): ?string
    {
        $result = str_replace(
            ' :where',
            $conditionFieldsString ? ' WHERE ' . $conditionFieldsString : '',
            $query
        );

        return $result;
    }

    /**
     * Put having conditions fields string in query.
     *
     * @param string $query
     * @param string|null $conditionFieldsString
     *
     * @return string|null
     */
    protected function putQueryHaving(string $query, string $conditionFieldsString = null): ?string
    {
        $result = str_replace(
            ' :having',
            $conditionFieldsString ? ' HAVING ' . $conditionFieldsString : '',
            $query
        );

        return $result;
    }

    /**
     * Get count value.
     *
     * @param array $result
     *
     * @return int
     */
    protected function getCountValue(array $result): int
    {
        // No any rows in result.
        if (empty($result)) {
            return 0;
        }

        $count = (int)$result[0]['COUNT'];

        return $count;
    }
}
