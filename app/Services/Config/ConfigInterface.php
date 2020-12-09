<?php

namespace AndrewSvirin\Interview\Services\Config;

/**
 * Wrapper for config data.
 */
interface ConfigInterface
{

    /**
     * Get config data by name.
     *
     * @param string $name The path to config data in dot syntax
     * @return mixed
     */
    public function get(string $name);
}
