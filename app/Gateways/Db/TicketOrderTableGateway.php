<?php

namespace AndrewSvirin\Interview\Gateways\Db;

use LogicException;

/**
 * Gateway operating with `ticket_orders` table.
 */
class TicketOrderTableGateway extends TableGateway
{

    const AUTO_INCREMENT = 'SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_NAME = "ticket_orders";';

    const CREATE = 'INSERT INTO `ticket_orders` ' .
    '(`id`, `airplane_id`, `person_name`) VALUES (?, ?, ?);';

    const FIND = '';

    /**
     * Get auto incrementing id.
     */
    public function getAutoIncrement(): int
    {
        $result = $this->dbClient->query(self::AUTO_INCREMENT);

        $id = (int)$result[0]['AUTO_INCREMENT'];

        return $id;
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
                $row['airplane_id'] ?? null,
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

        return [];
    }
}
