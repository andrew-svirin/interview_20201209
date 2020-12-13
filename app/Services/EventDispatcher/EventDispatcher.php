<?php

namespace AndrewSvirin\Interview\Services\EventDispatcher;

use AndrewSvirin\Interview\Exceptions\EventNotRegisteredException;
use AndrewSvirin\Interview\Services\Config;
use Psr\Container\ContainerInterface;

/**
 * Implements event dispatcher.
 * Dispatching events for trigger event listeners.
 */
class EventDispatcher
{

    /**
     * Application config.
     *
     * @var Config
     */
    private Config $config;

    /**
     * Container for perform event listeners.
     *
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(Config $config, ContainerInterface $container)
    {
        $this->config = $config;
        $this->container = $container;
    }

    /**
     * Dispatching event and perform event listeners.
     *
     * @param EventInterface $event
     *
     * @throws EventNotRegisteredException
     */
    public function dispatch(EventInterface $event): void
    {
        $eventSubscriptions = $this->config->get('event_subscriptions');

        $eventClass = get_class($event);

        // Check that event is registered in config.
        if (!isset($eventSubscriptions[$eventClass])) {
            throw new EventNotRegisteredException(sprintf('Event `%s` not registered in config.', $eventClass));
        }

        // Go over event listeners and perform.
        foreach ($eventSubscriptions[$eventClass] as $eventListenerClass) {
            /* @var $eventListener EventListenerInterface */
            $eventListener = $this->container->get($eventListenerClass);
            $eventListener->perform($event);
        }
    }
}
