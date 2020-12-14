<?php

namespace AndrewSvirin\Interview\Gateways\Db;

use LogicException;

/**
 * Gateway operating with `tickets` table.
 */
class TicketTableGateway extends TableGateway
{

    const AUTO_INCREMENT = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_NAME = "tickets";';

    const CREATE = 'INSERT INTO `tickets` ' .
    '(`id`, `ticket_order_id`, `airplane_id`, `row_number`, `sit_number`) VALUES (?, ?, ?, ?, ?);';

    const FIND = 'SELECT * FROM `tickets` :where;';

    const COUNT = 'SELECT COUNT(*) as `COUNT` FROM `tickets` :where;';

    const COUNT_BY_AIRPLANE_ROW = 'SELECT `airplane_id`, `row_number`, COUNT(*) as `COUNT` FROM tickets ' .
    'GROUP BY `airplane_id`, `row_number` :having;';

    /**
     * Get auto incrementing id.
     */
    public function getAutoIncrement(): int
    {
        $result = $this->dbClient->query(self::AUTO_INCREMENT);

        return $this->getAutoIncrementValue($result);
    }

    /**
     * Save row values to table.
     *
     * @param array $row
     *
     * @return int Id of saved value.
     */
    public function save(array $row): ?int
    {
        if (empty($row['id'])) {
            $id = $this->getAutoIncrement();
            $this->dbClient->query(self::CREATE, [
                $id,
                $row['ticket_order_id'] ?? null,
                $row['airplane_id'] ?? null,
                $row['row_number'] ?? null,
                $row['sit_number'] ?? null,
            ]);
        } else {
            throw new LogicException('Not predicted case for `update`.');
        }

        return $id;
    }

    /**
     * Find multiple rows by conditions.
     *
     * @param array $conditions
     *
     * @return array|null
     */
    public function findMultiple(array $conditions): ?array
    {
        // Apply condition fields in query.
        $conditionFieldsString = $this->prepareQueryConditionFieldsString(array_keys($conditions));

        // Put field conditions string in the query.
        $query = $this->putQueryWhere(self::FIND, $conditionFieldsString);


        // Prepare condition values.
        $conditionValues = array_values($conditions);

        // Do query.
        $rows = $this->dbClient->query($query, $conditionValues);

        return $rows;
    }

    /**
     * Count by conditions.
     *
     * @param array|null $conditions
     *
     * @return int
     */
    public function count(array $conditions = null): int
    {
        // Apply condition fields in query.
        $conditionFieldsString = $this->prepareQueryConditionFieldsString(array_keys($conditions));

        // Put field conditions string in the query.
        $query = $this->putQueryWhere(self::COUNT, $conditionFieldsString);

        // Prepare condition values.
        $conditionValues = array_values($conditions);

        // Do query.
        $result = $this->dbClient->query($query, $conditionValues);

        return $this->getCountValue($result);
    }

    /**
     * Get tickets in row by airplane.
     *
     * @param array $conditions
     *
     * @return array|false|mixed|null
     */
    public function countByRowAndAirplaneId(array $conditions)
    {
        // Apply condition fields in query.
        $conditionFieldsString = $this->prepareQueryConditionFieldsString(array_keys($conditions));

        // Put field conditions string in the query.
        $query = $this->putQueryHaving(self::COUNT_BY_AIRPLANE_ROW, $conditionFieldsString);

        // Prepare condition values.
        $conditionValues = array_values($conditions);

        // Do query.
        $result = $this->dbClient->query($query, $conditionValues);

        return $result;
    }
}
