<?php

namespace AndrewSvirin\Interview\Services\EventDispatcher;

/**
 * Procedure that will be performed by event.
 */
interface EventListenerInterface
{

    /**
     * Triggering method by event.
     *
     * @param EventInterface $event
     */
    public function perform(EventInterface $event): void;
}
