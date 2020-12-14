<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Builders\ApiResponseBuilder;
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

    public function __construct(
        ApiRequestValidator $validator,
        ApiResponseBuilder $apiResponseBuilder,
        TicketOrderFacade $ticketOrderFacade
    ) {
        parent::__construct($validator, $apiResponseBuilder);
        $this->ticketOrderFacade = $ticketOrderFacade;
    }

    /**
     * Create ticket order.
     *
     * @param CreateTicketOrderRequest $request
     *
     * @return ApiResponseBuilder
     */
    public function createAction(CreateTicketOrderRequest $request)
    {
        // Validate request.
        $violations = $this->validate($request);

        // Return errors on request violations.
        if (null !== $violations) {
            return $this->response(401)->withErrors($violations);
        }

        $requestValues = $request->validated();

        // Create model from request validated values.
        $model = $this->ticketOrderFacade->create($requestValues);

        // Save model.
        if (!$this->ticketOrderFacade->save($model, $requestValues['airplane_id'], $requestValues['sits_count'])) {
            return $this->response(401)->withMessage('Ticket order not created.');
        }

        return $this->response()->withMessage('Ticket order created.')->withModel($model);
    }
}
