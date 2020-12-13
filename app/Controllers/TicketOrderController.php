<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Exceptions\ModelNotSavedException;
use AndrewSvirin\Interview\Facades\TicketOrderFacade;
use AndrewSvirin\Interview\Requests\TicketOrder\CreateTicketOrderRequest;
use AndrewSvirin\Interview\Services\Validator\ApiRequestValidator;

/**
 * TicketOrder Controller implementation.
 */
class TicketOrderController extends ApiController
{

    /**
     * TicketOrder facade.
     *
     * @var TicketOrderFacade
     */
    private TicketOrderFacade $ticketOrder;

    public function __construct(ApiRequestValidator $validator, TicketOrderFacade $ticketOrder)
    {
        parent::__construct($validator);
        $this->ticketOrder = $ticketOrder;
    }

    /**
     * Create ticket order.
     *
     * @param CreateTicketOrderRequest $request
     *
     * @return array
     * @throws ModelNotSavedException
     */
    public function createAction(CreateTicketOrderRequest $request)
    {
        // Validate request.
        $violations = $this->validate($request);

        // Return errors on request violations.
        if (null !== $violations) {
            return $violations;
        }

        $requestValues = $request->validated();

        // Create model from request validated values.
        $model = $this->ticketOrder->create($requestValues);

        // Save model.
        if (!$this->ticketOrder->save($model, $requestValues['sits_count'])) {
            throw new ModelNotSavedException();
        }

        return [
            'message' => 'Ticket order created.',
            'data' => $model->getValues(),
        ];
    }
}
