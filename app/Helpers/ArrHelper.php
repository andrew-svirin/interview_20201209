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

        if (false === strpos($key, '.')) {
            return $array[$key];
        }
        foreach (explode('.', $key) as $segment) {
            if (isset($array[$segment])) {
                $array = $array[$segment];
            } else {
                $array = $default;
            }
        }

        return $array;
    }

    /**
     * Return only filtered fields from array.
     *
     * @param array $array Array for filtering.
     * @param array $fields Array of allowed fields.
     *
     * @return array
     */
    public static function filter(array $array, array $fields): array
    {
        return array_filter(
            $array,
            function ($key) use ($fields) {
                return in_array($key, $fields);
            },
            ARRAY_FILTER_USE_KEY
        );
    }
}
