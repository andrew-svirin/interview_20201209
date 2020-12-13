<?php

namespace AndrewSvirin\Interview\Requests\Airplane;

use AndrewSvirin\Interview\Requests\ApiRequest;
use AndrewSvirin\Interview\Validators\MaxValueValidator;
use AndrewSvirin\Interview\Validators\RequiredValueValidator;

/**
 * Create airplane request.
 * @see \AndrewSvirin\Interview\Controllers\AirplaneController::createAction()
 */
class CreateAirplaneRequest extends ApiRequest
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'aircraft_type' => [[RequiredValueValidator::class]],
            'sits_count' => [
                [RequiredValueValidator::class],
                [MaxValueValidator::class, ['max' => 1000]],
            ],
            'rows' => [[RequiredValueValidator::class]],
            'row_arrangement' => [[RequiredValueValidator::class]],
        ];
    }
}
