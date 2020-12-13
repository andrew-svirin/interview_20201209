<?php

namespace AndrewSvirin\Interview\Gateways\Db;

/**
 * Gateway operating with `airplane` table.
 */
class AirplaneTableGateway extends TableGateway
{

    const CREATE = '';

    /**
     * Save row values to table.
     *
     * @param array $values
     *
     * @return int Id of saved value.
     */
    public function save(array $values): int
    {
        $this->dbClient->connect();

        return 1;
    }
}
