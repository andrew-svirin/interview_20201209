<?php

namespace AndrewSvirin\Interview\Helpers;

/**
 * Array helper functions.
 */
class ArrHelper
{

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array $array
     * @param string|null $key
     * @param mixed $default
     *
     * @return mixed
     */
    public static function get(array $array, string $key = null, $default = null)
    {
        if (null === $key) {
            return $array;
        }

        // Key is simple.
        if (false === strpos($key, '.')) {
            return $array[$key];
        }

        $segments = explode('.', $key);

        // Go over key segments.
        foreach ($segments as $segment) {
            if (isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                $array = $default;
            }
        }

        return $array;
    }

    /**
     * Set value into array.
     *
     * @param array $array
     * @param string $key
     * @param mixed $value
     *
     * @return array
     */
    public static function set(array $array, string $key, $value): array
    {
        // Key is simple.
        if (false === strpos($key, '.')) {
            $array[$key] = $value;

            return $array;
        }

        $segments = explode('.', $key);

        $pointer = &$array;

        // Go over key segments.
        while (!empty($segments)) {
            // Shift segment.
            $segment = array_shift($segments);

            // Check if it is last segment.
            if (empty($segments)) {
                $pointer[$segment] = $value;
                break;
            }

            // Check if pointed element is array and place array.
            if (!is_array($pointer)) {
                $pointer[$segment] = [];
            }

            // Shift pointer into array.
            $pointer = &$pointer[$segment];
        }

        return $array;
    }

    /**
     * Return only filtered fields from array.
     * Array can be associative and list of associative arrays.
     *
     * @param array $array Array for filtering.
     * @param array $fields Array of allowed fields.
     *
     * @return array
     */
    public static function filter(array $array, array $fields): array
    {
        if (self::isAssoc($array)) {
            return array_filter(
                $array,
                function ($key) use ($fields) {
                    return in_array($key, $fields);
                },
                ARRAY_FILTER_USE_KEY
            );
        } else {
            foreach ($array as &$element) {
                $element = self::filter($element, $fields);
            }
            return $array;
        }
    }

    /**
     * Check that array is associative.
     *
     * @param array $array
     *
     * @return bool
     */
    public static function isAssoc(array $array): bool
    {
        $element = reset($array);

        return !is_array($element);
    }
}
