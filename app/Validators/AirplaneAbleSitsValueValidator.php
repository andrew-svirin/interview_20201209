<?php

namespace AndrewSvirin\Interview\Validators;

use AndrewSvirin\Interview\Facades\AirplaneFacade;
use AndrewSvirin\Interview\Facades\TicketFacade;
use AndrewSvirin\Interview\Services\Validator\ValueValidator;

/**
 * Validate value on maximum value.
 * Example:
 *   'field' => [['AirplaneAbleSitsValueValidator', ['airplane_id' => 100]]]
 */
class AirplaneAbleSitsValueValidator implements ValueValidator
{

    /**
     * Airplane facade.
     *
     * @var AirplaneFacade
     */
    private AirplaneFacade $airplaneFacade;

    /**
     * Ticket facade.
     *
     * @var TicketFacade
     */
    private TicketFacade $ticketFacade;

    public function __construct(AirplaneFacade $airplaneFacade, TicketFacade $ticketFacade)
    {
        $this->airplaneFacade = $airplaneFacade;
        $this->ticketFacade = $ticketFacade;
    }

    /**
     * Possible messages.
     *
     * @var array|string[]
     */
    protected array $messages = [
        'is_not_able' => 'Field :field has value of sits those are not able for airplane "%s".',
        'wrong_airplane' => 'Wrong airplane used.',
    ];

    /**
     * @inheritDoc
     *
     * @param array $options = [
     *   'airplane_id' => '<int>',
     * ]
     */
    public function validate($value, array $options = null): ?array
    {
        $violations = null;

        // No need to validate on empty value.
        if (empty($value)) {
            return $violations;
        }

        // Get airplane from options.
        $airplane = $this->airplaneFacade->findById($options['airplane_id']);

        // Check airplane exists.
        if (null === $airplane) {
            $violations[] = $this->messages['wrong_airplane'];
        }

        // Get tickets in airplane.
        $ticketsCount = $this->ticketFacade->countByAirplaneId($airplane->id);

        // Validate sits in airplane are able by comparison value with difference total sits and tickets.
        if ((int)$value > ($airplane->sits_count - $ticketsCount)) {
            $violations[] = sprintf($this->messages['is_not_able'], $airplane->id);
        }

        return $violations;
    }
}
