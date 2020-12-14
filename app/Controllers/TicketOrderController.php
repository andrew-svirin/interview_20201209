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
    private TicketOrderFacade $ticketOrderFacade;

    public function __construct(ApiRequestValidator $validator, TicketOrderFacade $ticketOrderFacade)
    {
        parent::__construct($validator);
        $this->ticketOrderFacade = $ticketOrderFacade;
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
        $model = $this->ticketOrderFacade->create($requestValues);

        // Save model.
        if (!$this->ticketOrderFacade->save($model, $requestValues['airplane_id'], $requestValues['sits_count'])) {
            throw new ModelNotSavedException();
        }

        return [
            'message' => 'Ticket order created.',
            'data' => $model->getValues(),
        ];
    }
}
