<?php

namespace AndrewSvirin\Interview\Factories\Models;

use AndrewSvirin\Interview\Exceptions\ClassNamespaceIncorrectException;
use AndrewSvirin\Interview\Exceptions\ClassNotExistsException;
use AndrewSvirin\Interview\Models\Model;
use ReflectionClass;

/**
 * Produce child model instance.
 * Abstract factory.
 */
class ModelFactory
{

    /**
     * Produce model instance from class name.
     *
     * @param string $className
     *
     * @return Model
     * @throws ClassNamespaceIncorrectException
     * @throws ClassNotExistsException
     * @throws \ReflectionException
     */
    public function createModel(string $className): Model
    {
        // Check that class name exists.
        if (!class_exists($className)) {
            throw new ClassNotExistsException(sprintf('Request class `%s` not found.', $className));
        }

        // Check that class name is child of api request.
        if (!is_subclass_of($className, Model::class)) {
            throw new ClassNamespaceIncorrectException(sprintf(
                'Allowed argument with instance of `%s`.',
                Model::class
            ));
        }

        // Create reflection class.
        $class = new ReflectionClass($className);

        // Create instance of class by reflection class.
        /* @var $model Model */
        $model = $class->newInstanceArgs();

        return $model;
    }
}
