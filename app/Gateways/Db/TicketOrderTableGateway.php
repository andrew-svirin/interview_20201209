<?php

namespace AndrewSvirin\Interview\Gateways\Db;

use LogicException;

/**
 * Gateway operating with `ticket_orders` table.
 */
class TicketOrderTableGateway extends TableGateway
{

    const AUTO_INCREMENT = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_NAME = "ticket_orders";';

    const CREATE = 'INSERT INTO `ticket_orders` (`id`, `person_name`) VALUES (?, ?);';

    const FIND = 'SELECT * FROM `ticket_orders`%s;';

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
                $row['person_name'] ?? null,
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
        $query = sprintf(self::FIND, $conditionFieldsString ? ' WHERE ' . $conditionFieldsString : '');


        // Prepare condition values.
        $conditionValues = array_values($conditions);

        // Do query.
        $rows = $this->dbClient->query($query, $conditionValues);

        return $rows;
    }
}
