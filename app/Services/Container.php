<?php

namespace AndrewSvirin\Interview\Services;

use AndrewSvirin\Interview\Exceptions\ServiceInvalidException;
use LogicException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionParameter;

/**
 * Contains IoC services dependencies.
 * Realizing pattern ServiceLocator.
 */
class Container implements ContainerInterface
{

    /**
     * Instantiated classes.
     * @var array [
     *   [
     *     'entry' => '<instance>',
     *   ]
     * ]
     */
    private array $instantiated = [];

    public function __construct(Config $config, ServiceRegistry $registry)
    {
        $this->instantiated[Config::class]['entry'] = $config;
        $this->instantiated[ServiceRegistry::class]['entry'] = $registry;
    }

    /**
     * @inheritDoc
     *
     * Find service in registry.
     * If service will not be found in container, then create new one.
     * @throws ServiceInvalidException
     */
    public function get($id)
    {
        // Check if service is not instantiated yet.
        if (!isset($this->instantiated[$id])) {
            // Create new instance and put to container store.
            $this->instantiated[$id] = $this->resolveInstance($id);
        }

        return $this->instantiated[$id]['entry'];
    }

    /**
     * @inheritDoc
     *
     * Find service class name in registry and check if it is instantiable.
     */
    public function has($id)
    {
        // Check if service is instantiated already.
        if (isset($this->instantiated[$id])) {
            return true;
        }

        // Try to find in registry service class name.
        $service = $this->instantiated[ServiceRegistry::class]['entry']->get($id);

        return $this->isServiceInstantiable($service);
    }

    /**
     * Check that service class name is instantiable
     *
     * @param string|array $service
     *
     * @return bool
     */
    private function isServiceInstantiable($service)
    {
        // If registry service is class name.
        if (is_string($service) && class_exists($service)) {
            try {
                // Get class reflection.
                $class = new ReflectionClass($service);
            } catch (ReflectionException $exception) {
                return false;
            }
        } else {
            // TODO: Add more options for pass specific arguments to constructor.
            throw new LogicException(sprintf('Incorrect registry service %s.', serialize($service)));
        }

        return $class->isInstantiable();
    }

    /**
     * Create new instance by registry.
     *
     * @param string $id The service id in container.
     *
     * @return array
     * @throws ServiceInvalidException
     */
    private function resolveInstance(string $id)
    {
        // Try to find in registry service class name.
        $service = $this->instantiated[ServiceRegistry::class]['entry']->get($id);

        // If registry service is class name.
        if (is_string($service) && class_exists($service)) {
            // Create new instance by reflection and add instance arguments.
            try {
                $class = new ReflectionClass($service);
            } catch (ReflectionException $exception) {
                throw new ServiceInvalidException();
            }

            $entry = $this->resolveEntry($class);
        } else {
            // TODO: Add more options for pass specific arguments to constructor.
            throw new LogicException(sprintf('Incorrect registry service %s.', serialize($service)));
        }

        // TODO: Add lock to avoid recursive over loop.
        return [
            'entry' => $entry,
        ];
    }

    /**
     * Resolve entry from reflection class.
     *
     * @param ReflectionClass $class
     *
     * @return object
     * @throws ServiceInvalidException
     */
    private function resolveEntry(ReflectionClass $class)
    {
        if (($constructor = $class->getConstructor())) {
            $arguments = $this->resolveClassArguments($constructor->getParameters());
        }

        return $class->newInstanceArgs($arguments ?? []);
    }

    /**
     * Resolve arguments from constructor parameters.
     *
     * @param ReflectionParameter[] $parameters
     *
     * @return array
     * @throws ServiceInvalidException
     */
    private function resolveClassArguments(array $parameters): array
    {
        $entries = [];

        // Go over constructor parameters.
        foreach ($parameters as $parameter) {
            // Get service id from parameter class.
            $id = $parameter->getClass()->getName();

            if (!isset($this->instantiated[$id])) {
                // Resolve entry and put to arguments.
                $this->instantiated[$id] = $this->resolveInstance($id);
            }

            $entries[] = $this->instantiated[$id]['entry'];
        }

        return $entries;
    }
}
