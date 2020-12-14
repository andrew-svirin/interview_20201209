<?php

namespace AndrewSvirin\Interview\Requests\TicketOrder;

use AndrewSvirin\Interview\Requests\ApiRequest;
use AndrewSvirin\Interview\Validators\AirplaneAbleSitsValueValidator;
use AndrewSvirin\Interview\Validators\MaxValueValidator;
use AndrewSvirin\Interview\Validators\RequiredValueValidator;

/**
 * Create ticket order request.
 * @see \AndrewSvirin\Interview\Controllers\TicketOrderController::createAction()
 */
class CreateTicketOrderRequest extends ApiRequest
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        $json = $this->getJson();
        return [
            'airplane_id' => [[RequiredValueValidator::class]],
            'sits_count' => [
                [RequiredValueValidator::class],
                [MaxValueValidator::class, ['max' => 7]],
                [AirplaneAbleSitsValueValidator::class, ['airplane_id' => $json['airplane_id'] ?? '']],
            ],
            'person_name' => [[RequiredValueValidator::class]],
        ];
    }
}
