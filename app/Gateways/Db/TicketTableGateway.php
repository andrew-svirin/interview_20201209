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
    '(`id`, `ticket_order_id`, `row_number`, `sit_number`) VALUES (?, ?, ?, ?);';

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
                $row['ticket_order_id'] ?? null,
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

        return [];
    }
}
