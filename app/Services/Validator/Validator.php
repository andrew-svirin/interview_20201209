<?php

namespace AndrewSvirin\Interview\Services\Validator;

use Psr\Container\ContainerInterface;

/**
 * Validates value by rules.
 */
class Validator
{

    /**
     * Container for get validator services.
     *
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Validate value by rules and response violations on errors.
     *
     * @param mixed $value Value for validation
     * @param array $rules Rules for validation.
     *
     * @return array|null
     */
    public function validate($value, array $rules): ?array
    {
        $violations = null;

        foreach ($rules as $rule) {
            // Parse rule on value validator class name and validation options.
            if (2 === count($rule)) {
                [$className, $options] = $rule;
            } else {
                // Rule describes by class name.
                [$className] = $rule;
            }

            /* @var $valueValidator ValueValidator */
            $valueValidator = $this->container->get($className);
            $ruleViolations = $valueValidator->validate($value, $options ?? null);

            // Ignore when value does not violate rule.
            if (null === $ruleViolations) {
                continue;
            }

            $violations[] = $ruleViolations;
        }

        return $violations;
    }
}
