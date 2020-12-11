<?php

namespace AndrewSvirin\Interview\Requests\Site;

use AndrewSvirin\Interview\Requests\ApiRequest;

/**
 * Create airplane request.
 * @see \AndrewSvirin\Interview\Controllers\AirplaneController::createAction()
 */
class CreateAirplane extends ApiRequest
{

    /**
     * @inheritDoc
     */
    protected function rules(): array
    {
        return [
            'aircraft_type',
            'sits_count',
            'rows',
            'row_arrangement',
        ];
    }
}
