<?php

namespace AndrewSvirin\Interview\Requests\TicketOrder;

use AndrewSvirin\Interview\Requests\ApiRequest;
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
        return [
            'airplane_id' => [[RequiredValueValidator::class]],
            'sits_count' => [
                [RequiredValueValidator::class],
                [MaxValueValidator::class, ['max' => 7]],
            ],
            'person_name' => [[RequiredValueValidator::class]],
        ];
    }
}
