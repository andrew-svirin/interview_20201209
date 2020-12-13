<?php

namespace AndrewSvirin\Interview\Repositories;

use AndrewSvirin\Interview\Gateways\Db\AirplaneTableGateway;

/**
 * Airplane repository implements db layer operations with model Airplane.
 */
class AirplaneRepository
{

    /**
     * Airplane table gateway.
     *
     * @var AirplaneTableGateway
     */
    private AirplaneTableGateway $airplaneTableGateway;

    public function __construct(AirplaneTableGateway $airplaneTableGateway)
    {
        $this->airplaneTableGateway = $airplaneTableGateway;
    }
}
