<?php

namespace AndrewSvirin\Interview\Controllers;

use AndrewSvirin\Interview\Builders\ApiResponseBuilder;
use AndrewSvirin\Interview\Facades\TicketFacade;
use AndrewSvirin\Interview\Requests\Ticket\ViewListTicketRequest;
use AndrewSvirin\Interview\Services\Validator\ApiRequestValidator;

/**
 * Ticket Controller implementation.
 */
class TicketController extends ApiController
{

    /**
     * Ticket facade.
     *
     * @var TicketFacade
     */
    private TicketFacade $ticketFacade;

    public function __construct(
        ApiRequestValidator $validator,
        ApiResponseBuilder $apiResponseBuilder,
        TicketFacade $ticketFacade
    ) {
        parent::__construct($validator, $apiResponseBuilder);
        $this->ticketFacade = $ticketFacade;
    }

    /**
     * View list of tickets.
     *
     * @param ViewListTicketRequest $request
     *
     * @return ApiResponseBuilder
     */
    public function viewListAction(ViewListTicketRequest $request)
    {
        // Retrieve tickets by conditions.
        $models = $this->ticketFacade->findMultiple($request->conditions());

        return $this->response()->withMessage('Tickets list.')->withModels($models);
    }
}
